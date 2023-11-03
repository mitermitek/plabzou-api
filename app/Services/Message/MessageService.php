<?php

namespace App\Services\Message;

use App\Models\Message;

class MessageService
{
    /**
     * Permet de créer un message
     *
     * @param array $data
     * @return Message
     */
    public static function createMessage(array $data)
    {
        return Message::create($data);
    }
}
