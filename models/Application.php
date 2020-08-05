<?php

namespace app\models;

use Yii;
use \app\models\base\Application as BaseApplication;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "application".
 */
class Application extends BaseApplication
{

    public function behaviors()
    {
        return ArrayHelper::merge(
            parent::behaviors(),
            [
                # custom behaviors
            ]
        );
    }

    public function rules()
    {
        return ArrayHelper::merge(
            parent::rules(),
            [
                # custom validation rules
            ]
        );
    }
}
