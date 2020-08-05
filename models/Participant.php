<?php

namespace app\models;

use Yii;
use \app\models\base\Participant as BaseParticipant;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "participant".
 */
class Participant extends BaseParticipant
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
