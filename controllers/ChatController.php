<?php
/*
 * Copyright (c) 2020. Febrianto Arif Rakhman
 *
 * Written by Febrianto Arif Rakhman <febfeb.90@gmail.com>
 */

namespace app\controllers;

use app\models\Chatting;
use app\models\RoomParticipant;

class ChatController extends RestController
{
    public function actionGetChatList()
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
            $lastMessage = Chatting::find()->where(["room_id"=>$roomParticipant->room_id])->orderBy("id DESC")->one();

            $listRoom = [
                "title" => implode(", ", $listParticipantName),
                "token" => $roomParticipant->room->token,
                "last_message" => $lastMessage ? $lastMessage->message : "",
                "last_update" => $lastMessage ? $lastMessage->created_at : $roomParticipant->created_at
            ];
        }

        return $listRoom;
    }
}