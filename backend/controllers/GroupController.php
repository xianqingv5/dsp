<?php
namespace backend\controllers;

use Yii;
use yii\web\Response;
use backend\services\GroupService;


class GroupController extends BaseController
{
    /**
     * 群组列表页
     * @return array|string
     */
    public function actionGroupIndex()
    {
        if (Yii::$app->request->isAjax && Yii::$app->request->isPost) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $data = GroupService::getGroupData();
            return $data;
        }

        return $this->render('group-index', []);
    }

    /**
     * 获取群组权限信息
     */
    public function actionGetGroupPrev()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $res = GroupService::getGroupPrev();
        return $res;
    }

    public function actionAddGroupPrev()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $res = GroupService::addGroupPrev();
        return $res;
    }

    public function actionUpdateGroupStatus()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $res = GroupService::updateGroupStatus();
        return $res;
    }
}