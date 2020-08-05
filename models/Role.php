<?php

namespace app\models;

use app\models\base\Role as BaseRole;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "role".
 */
class Role extends BaseRole
{
    const SUPER_ADMINISTRATOR = 1;
}
