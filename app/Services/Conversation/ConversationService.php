<?php

namespace App\Services\Conversation;

use App\Models\Conversation;
use App\Services\AdministrativeEmployee\AdministrativeEmployeeService;

class ConversationService
{
    /**
     * Créer une nouvelle conversation
     *
     * @param array $data
     * @return Conversation
     */
    public static function createConversation(array $data): Conversation
    {
        $conversation = Conversation::create($data);

        //On ajoute les membres de la conversation
        $adminIds = AdministrativeEmployeeService::getAllAdministrativeEmployeeId();
        $conversation->members()->sync($adminIds);
        $conversation->members()->attach($data['teacher_id']);

        return $conversation;
    }
}
