<?php

namespace App\Http\Controllers\API\Conversation;

use App\Http\Controllers\API\BaseController;
use App\Http\Requests\API\Conversation\ConversationRequest;
use App\Services\Conversation\ConversationService;
use Illuminate\Http\JsonResponse;

class ConversationController extends BaseController
{

    public function store(ConversationRequest $request): JsonResponse
    {
        $conversation = ConversationService::createConversation($request->validated());

        return $this->success($conversation->toArray(), "La conversation a bien été créée.");
    }
}
