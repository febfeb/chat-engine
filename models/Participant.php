<?php

namespace app\models;

use app\models\base\Participant as BaseParticipant;
use Yii;

/**
 * This is the model class for table "participant".
 */
class Participant extends BaseParticipant
{
    public function addToCache()
    {
        $cache = Yii::$app->cache;
        $arr = $cache->get("participant");
        if ($arr == null) {
            $arr = [];
        }
        $arr[$this->token] = $this->name;
        $cache->set("participant", $arr);
    }

    public static function getParticipantCache()
    {
        $cache = Yii::$app->cache;
        $arr = $cache->get("participant");
        if ($arr == null) {
            $arr = [];
        }

        return $arr;
    }
}
