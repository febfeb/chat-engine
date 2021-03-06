<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $name
 * @property integer $role_id
 * @property integer $status
 * @property string $last_login
 * @property string $last_logout
 * @property string $created_at
 * @property string $updated_at
 *
 * @property \app\models\Role $role
 * @property string $aliasModel
 */
abstract class User extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'status'], 'integer'],
            [['last_login', 'last_logout', 'created_at', 'updated_at'], 'safe'],
            [['username', 'name'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 100],
            [['username'], 'unique'],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Role::className(), 'targetAttribute' => ['role_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'password' => 'Password',
            'name' => 'Name',
            'role_id' => 'Role ID',
            'status' => 'Status',
            'last_login' => 'Last Login',
            'last_logout' => 'Last Logout',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints()
    {
        return array_merge(parent::attributeHints(), [
            'status' => '0 = non aktif, 1 = aktif',
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(\app\models\Role::className(), ['id' => 'role_id']);
    }




}
