<?php

namespace app\models;

use Yii;
use \app\models\base\Room as BaseRoom;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "room".
 */
class Room extends BaseRoom
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
