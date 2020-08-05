<?php
/*
 * Copyright (c) 2020. Febrianto Arif Rakhman
 *
 * Written by Febrianto Arif Rakhman <febfeb.90@gmail.com>
 */

namespace app\controllers;

use app\models\Application;
use app\models\Chatting;
use app\models\Participant;
use app\models\Room;
use app\models\RoomParticipant;
use Yii;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;

class ChatController extends RestController
{
    public function actionGetRoom()
    {
        $listRoom = [];

        /** @var RoomParticipant[] $rooms */
        $rooms = RoomParticipant::find()->where(["participant_id" => $this->participant->id])->all();
        foreach ($rooms as $roomParticipant) {
            //get all participant in that room except himself
            $listParticipantName = [];

            /** @var RoomParticipant[] $allParticipants */
            $allParticipants = RoomParticipant::find()->where(["room_id" => $roomParticipant->room_id])
                ->andWhere("participant_id != '{$this->participant->id}'")
                ->all();
            foreach ($allParticipants as $rParticipant) {
                $listParticipantName[] = $rParticipant->participant->name;
            }

            /** @var Chatting $lastMessage */
            $lastMessage = Chatting::find()->where(["room_id" => $roomParticipant->room_id])->orderBy("id DESC")->one();

            $listRoom = [
                "title" => implode(", ", $listParticipantName),
                "token" => $roomParticipant->room->token,
                "last_message" => $lastMessage ? $lastMessage->message : "",
                "last_update" => $lastMessage ? $lastMessage->created_at : $roomParticipant->created_at
            ];
        }

        return $listRoom;
    }

    public function actionGetChat($room_id)
    {
        $participantCache = Participant::getParticipantCache();
        /** @var Room $room */
        $room = Room::find()->where(["token" => $room_id])->one();
        if ($room) {
            $output = [];

            /** @var Chatting $chatting */
            foreach (Chatting::find()->where(["room_id" => $room->id])->all() as $chatting) {
                $output[] = [
                    "sender_name" => $participantCache[$chatting->participant_token],
                    "message" => $chatting->message,
                    "created_at" => $chatting->created_at,
                ];
            }

            return $output;
        }

        throw new NotFoundHttpException("Room ID Not Found");
    }

    public function actionSendChat($room_id, $message)
    {
        /** @var Room $room */
        $room = Room::find()->where(["token" => $room_id])->one();
        if ($room) {
            $msg = new Chatting();
            $msg->room_id = $room_id;
            $msg->participant_token = $this->participant->token;
            $msg->message = $message;
            $msg->created_at = date("Y-m-d H:i:s");
            if ($msg->save()) {
                return ["status" => "OK"];
            }
        }

        throw new NotFoundHttpException("Room ID Not Found");
    }

    public function actionRegisterUser()
    {
        $headers = Yii::$app->request->headers;
        $appToken = $headers->get("X-App-Token");
        $appSecret = $headers->get("X-App-Secret");

        $application = Application::find()->where(["token" => $appToken, "secret" => $appSecret])->one();

        if ($application == null) {
            throw new BadRequestHttpException("X-App-Secret Not Found");
        }

        $json = file_get_contents('php://input');
        $obj = json_decode($json, true);

        $output = [];

        foreach ($obj as $key => $value) {
            $user = Participant::find()->where(["local_id" => $key])->one();
            if ($user == null) {
                $user = new Participant();
                $user->local_id = $key;
                $user->token = Yii::$app->security->generateRandomKey();
                $user->name = $value;
                $user->created_at = date("Y-m-d H:i:s");
                $user->save();
            }

            $output[$user->local_id] = $user->token;
        }

        return $output;
    }
}