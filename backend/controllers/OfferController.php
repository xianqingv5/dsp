<?php
namespace backend\controllers;

use Yii;
use backend\services\OfferService;

class OfferController extends BaseController
{
    public function actionOfferIndex()
    {
        return $this->render('offer-index');
    }

    public function actionOfferCreate()
    {
        return $this->render('offer');
    }

    public function actionOfferUpdate()
    {

    }

    public function actionOfferUpdateStatus()
    {

    }

    public function actionDelOfferImg()
    {

    }
}