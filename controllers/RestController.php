<?php


namespace app\controllers;


use app\models\Application;
use app\models\Participant;
use Yii;
use yii\rest\Controller;
use yii\web\BadRequestHttpException;

class RestController extends Controller
{
    /** @var $application Application */
    public $application = null;

    /** @var $participant Participant */
    public $participant = null;

    public function beforeAction($action)
    {
        $headers = Yii::$app->request->headers;
        $appToken = $headers->get("X-App-Token");

        $application = Application::find()->where(["token" => $appToken])->one();

        if ($application == null) {
            throw new BadRequestHttpException("X-App-Token Not Found");
        }

        $userToken = $headers->get("X-User-Token");

        $participant = Participant::find()->where(["token" => $userToken])->one();

        if ($participant == null) {
            throw new BadRequestHttpException("X-User-Token Not Found");
        }

        $this->participant = $participant;

        return true;
    }
}