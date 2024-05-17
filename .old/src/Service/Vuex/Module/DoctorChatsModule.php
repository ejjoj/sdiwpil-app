<?php

namespace App\Service\Vuex\Module;

use App\Service\Conversation\ConversationService;
use Doctrine\Common\Collections\ArrayCollection;

class DoctorChatsModule extends AbstractModule
{
    public function __construct(private readonly ConversationService $conversationService)
    {
    }

    public function insertIntoState(ArrayCollection $state): void
    {
        $state->set('doctor_chats', ['conversations' => $this->conversationService->getConversations()]);

        parent::insertIntoState($state);
    }
}
