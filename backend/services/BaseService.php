<?php
namespace backend\services;

use Yii;
use yii\log\Logger;
use common\models\UserGroup;
use common\models\GroupRelationPriv;
use common\models\User;
use yii\web\ForbiddenHttpException;

class BaseService
{

    CONST LOG_CATEGORY = 'dsp';
    CONST LOG_SEPARATOR = ' ---- ';

    /**
     * 重定向登录用的的家目录
     * @param int $group_id
     * @throws ForbiddenHttpException
     */
    public static function redirectHomeUrl($group_id = 0)
    {
        // 获取群组id
        $gid   = $group_id ? $group_id :Yii::$app->user->identity->group_id;
        // 取得roles & home url list
        $home_url_list  = Yii::$app->params['HOME_URL_BY_ROLE'];
        // 取得home url
        $home_url = !empty($home_url_list[$gid]) ? $home_url_list[$gid] : '';

        if (empty($home_url)) {
            throw new ForbiddenHttpException();
        }

        // 广告主
        if ($gid == 4) {
            $home_url = $home_url_list . "?uid=" . Yii::$app->user->identity->id;
        }

        header("Location:" . '/' . $home_url);
        exit;
    }

    /**
     * 将用户id email 定义到视图页面
     */
    public static function setRequestUidToView()
    {
        // 取得当前请求用户id
        $request_uid    = Yii::$app->request->get('uid', 0);
        $request_uid    = !empty($request_uid) ? $request_uid : Yii::$app->user->identity->id;

        Yii::$app->view->params['request_uid'] = $request_uid;
        Yii::$app->view->params['request_email'] = User::findIdentity($request_uid)['email'];

    }

    /**
     * 获取组信息
     * @param int $group_id
     * @param array $fields
     * @return array|string
     */
    public static function getGroupData($group_id = 0, $fields = ['*'])
    {
        $where = ['1=1'];
        if ($group_id) {
            $where['id'] = "id='" . $group_id . "'";
        }
        $res = UserGroup::getData($fields, $where);
        return $res;
    }

    /**
     * 获取组权限
     * @param $group_id
     * @return array
     */
    public static function getGroupRelationPriv($group_id)
    {
        $res = GroupRelationPriv::getData(['prev_url'], ["group_id = '" . $group_id . "'"]);
        return !empty($res) ? array_column($res, 'prev_url') : [];
    }

    /**
     * 获取控制器名和方法名
     * @return array
     */
    public static function getControllerAndAction()
    {
        $controller_id  = Yii::$app->controller->id;
        $action_id      = Yii::$app->controller->action->id;

        return [
            'c'    => $controller_id,
            'a'    => $action_id
        ];
    }

    /**
     * 错误写入日志
     * @param $message
     */
    public static function logs($message) {
        $controller = Yii::$app->controller->id;
        $action = Yii::$app->controller->action->id;
        $message =  "$controller/$action : " . $message . "\n";
        Yii::getLogger()->log($message, Logger::LEVEL_ERROR);
    }

    /**
     * 用户操作log
     *
     * @param array $message
     * @return bool
     */
    public static function generateLog($message = [])
    {
        $data['inner_email']        = (!Yii::$app->user->isGuest) ?
            Yii::$app->user->identity->email :
            'Guest';

        $data['inner_controller']   = Yii::$app->controller->id;
        $data['inner_action']       = Yii::$app->controller->action->id;
        $data['inner_url']          = Yii::$app->request->getUrl();

        $post_data                  = self::getPostData();

        $content = implode(self::LOG_SEPARATOR, array_merge($data, $message, $post_data));
        $content = self::LOG_SEPARATOR . $content . self::LOG_SEPARATOR;

        Yii::info($content, self::LOG_CATEGORY);
    }

    /**
     * 获取操作数据
     * @return array|mixed|string
     */
    public static function getPostData()
    {
        $post_data  = [];
        if ( !Yii::$app->request->isPost ) return $post_data;

        $post_data  = Yii::$app->request->post();

        // 去掉敏感信息
        if ( isset($post_data['User']['new_password']) ) {
            unset($post_data['User']['new_password']);
        }
        if ( isset($post_data['User']['password']) ) {
            unset($post_data['User']['password']);
        }
        if ( isset($post_data['LoginForm']['password']) ) {
            unset($post_data['LoginForm']['password']);
        }

        $post_data  = json_encode($post_data);
        return [$post_data];
    }

}