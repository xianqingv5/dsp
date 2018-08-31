<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\services\BaseService;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\web\Cookie;

class BaseController extends Controller
{
    public function beforeAction($action)
    {
        if( !parent::beforeAction($action) ) return false;

        // 取得当前请求url
        $controller_and_action = BaseService::getControllerAndAction();
        $request_action = $controller_and_action['c'] . '/' . $controller_and_action['a'];

        // 操作记录
        $record_log = Yii::$app->params['LOG_RECORD_METHOD'];
        if (in_array($request_action, $record_log)) {
            BaseService::generateLog();
        }

        // 检测action是否需要登录
        $no_login_actions = Yii::$app->params['NO_LOGIN_ACTIONS'];
        if (in_array($request_action, $no_login_actions)) {
            return true;
        }

        // 检测user是否登录
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site/index')->send();// 重定向至登录页面
        }

        // 检测group是否可用
        $group_id = Yii::$app->user->identity->group_id;
        $group_information = BaseService::getGroupData($group_id);
        if (empty($group_information) || $group_information[0]['status'] != 1) {
            throw new ForbiddenHttpException();
        }

        //判断用户是否有权限进入当前控制器下的方法
        $group_privs = BaseService::getGroupRelationPriv($group_id);
        if (empty($group_privs) || !in_array($request_action, $group_privs)) {
            throw new ForbiddenHttpException();
        }

        // 设置request uid、email到view视图中
        BaseService::setRequestUidToView();
        return true;
    }

    /**
     * 初始化信息
     */
    public function init()
    {
        // language init
        $cookies = Yii::$app->request->cookies;
        $language = $cookies->getValue('lang', 'en');
        Yii::$app->language = $language;
    }

    /**
     *   语言包切换
     */
    public function actionLanguage() {
        //接收切换语言
        $language = Yii::$app->request->get('lang','');
        if(!empty($language)){
            $cookie = new Cookie(['name' => 'lang', 'value' => $language, 'expire' => time() + 3600*24*30]);
            Yii::$app->response->cookies->add($cookie);
        }
        //切换完语言哪来的返回到哪里
        $this->goBack(Yii::$app->request->headers['Referer']);
    }

}