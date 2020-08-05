<?php


namespace app\controllers;


use Yii;
use yii\web\Controller;

class BaseController extends Controller
{
    public function beforeAction($action)
    {
        date_default_timezone_set("Asia/Jakarta");

        if(Yii::$app->user->isGuest){
            return $this->redirect(["site/login"]);
        }

        return parent::beforeAction($action);
    }
}