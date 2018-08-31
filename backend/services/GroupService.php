<?php
namespace backend\services;

use Codeception\Platform\Group;
use Yii;
use common\models\UserGroup;
use common\models\GroupRelationPriv;

class GroupService extends BaseService
{
    public static function getGroupPrev()
    {
        $res = ['status' => 0, 'info' => '', 'data' => []];
        $group_id = (int)Yii::$app->request->post('group_id', 0);
        if (!$group_id) {
            $res['info'] = '参数错误';
            return $res;
        }
        $group_prev = Yii::$app->params['GROUP_PREV'];
        if (empty($group_prev)) {
            $res['info'] = '群组配置为空';
            return $res;
        }

        // 组装群组信息
        $i = 0; $group_all = [];
        foreach ($group_prev as $k=>$v){
            $group_all[$i]['label'] = $v;
            $group_all[$i]['key'] = $k;
            $i++;
        }
        $res['status'] = 1;
        $res['data']['all'] = $group_all;

        // 查询群组已有权限
        $group_res = GroupRelationPriv::getData(['prev_url'], ["group_id='" . $group_id . "'"]);
        $res['data']['group'] = [];
        if (!empty($group_res)) {
            $res['data']['group'] = array_column($group_res, 'prev_url');
        }

        return $res;
    }

    /**
     * 群组权限添加
     * @return array
     */
    public static function addGroupPrev()
    {
        $res = ['status' => 0, 'info' => '', 'data' => []];
        $group_id = (int)Yii::$app->request->post('group_id', 0);
        if (empty($group_id)) {
            $res['info'] = '参数错误';
            return $res;
        }
        $prev = Yii::$app->request->post('prev', []);
        $transaction = Yii::$app->db->beginTransaction();
        try {

            // 判断表中是否已有权限,如果存在就删除
            $r = GroupRelationPriv::getData(['count(*) as num'], ["group_id='" . $group_id . "'"]);
            $del_group_res = true;
            if ($r[0]['num']) {
                $del_group_res = GroupRelationPriv::deleteData(["group_id" => $group_id]);
            }

            $prev_res = true;
            if (!empty($prev)) {
                // 重新添加权限
                foreach ($prev as $k=>$v) {
                    $data['group_id'] = $group_id;
                    $data['prev_url'] = $v;
                    $prev_r = GroupRelationPriv::addData($data);
                    if (!$prev_r) {
                        $prev_res = false;
                    }
                }
            }

            if ($del_group_res && $prev_res) {
                $res['status'] = 1;
                $res['info'] = 'success';
                $transaction->commit();
            }
        } catch (\Exception $e) {
            self::logs($e->getMessage());
            $transaction->rollBack();
            $res['info'] = $e->getMessage();
        }

        return $res;
    }

    public static function updateGroupStatus()
    {
        $res = ['status' => 0, 'info' => '', 'data' => []];
        $group_id = (int)Yii::$app->request->post('group_id', 0);
        $status = (int)Yii::$app->request->post('status', 0);
        if (!$group_id || !$status) {
            $res['info'] = '参数错误';
            return $res;
        }

        $transaction = Yii::$app->db->beginTransaction();
        try {
            $info = UserGroup::updateData(['status'=>$status], ['id'=>$group_id]);
            if ($info) {
                $res['status'] = 1;
                $res['info'] = 'success';
                $transaction->commit();
            }
        } catch (\Exception $e) {
            self::logs($e->getMessage());
            $res['info'] = $e->getMessage();
            $transaction->rollBack();
        }

        return $res;

    }
}