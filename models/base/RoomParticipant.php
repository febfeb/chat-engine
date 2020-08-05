<?php
// This class was automatically generated by a giiant build task
// You should not change it manually as it will be overwritten on next build

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "room_participant".
 *
 * @property integer $id
 * @property integer $room_id
 * @property integer $participant_id
 * @property string $created_at
 *
 * @property \app\models\Room $room
 * @property \app\models\Participant $participant
 * @property string $aliasModel
 */
abstract class RoomParticipant extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'room_participant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['room_id', 'participant_id', 'created_at'], 'required'],
            [['room_id', 'participant_id'], 'integer'],
            [['created_at'], 'safe'],
            [['room_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Room::className(), 'targetAttribute' => ['room_id' => 'id']],
            [['participant_id'], 'exist', 'skipOnError' => true, 'targetClass' => \app\models\Participant::className(), 'targetAttribute' => ['participant_id' => 'id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'room_id' => 'Room ID',
            'participant_id' => 'Participant ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoom()
    {
        return $this->hasOne(\app\models\Room::className(), ['id' => 'room_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParticipant()
    {
        return $this->hasOne(\app\models\Participant::className(), ['id' => 'participant_id']);
    }




}