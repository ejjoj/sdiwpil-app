<?php

namespace App\Service\Conversation;

use App\Entity\Conversation;
use App\Entity\Message;
use App\Entity\User;
use App\Service\PaginatedRequestService;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\Security\Core\Security;

class ConversationService
{
    private User $user;

    public function __construct(
        private readonly Security $security,
        private readonly PaginatedRequestService $paginatedRequestService,
        private readonly EntityManagerInterface $entityManager
    ) {
        $this->setUser();
    }

    public function getConversations(): array
    {
        $minMax = $this->paginatedRequestService->getMinMax();
        /** @var Conversation[] $conversations */
        $conversations = $this->entityManager->getRepository(Conversation::class)
            ->getPaginatedConversations($this->user, $minMax['min'], $minMax['max']);
        foreach ($conversations as $conversation) {
            $result[] = $this->getFrontEndConversation($conversation);
        }

        return $result ?? [];
    }

    private function setUser(): void
    {
        /** @var User $user */
        $user = $this->security->getUser();
        if (!$user) {
            throw new RuntimeException('User not found');
        }

        $this->user = $user;
    }

    private function getFrontEndConversation(Conversation $conversation): array
    {
        /** @var Message $lastMessage */
        $lastMessage = $conversation->getMessages()->last();
        $conversationArray = $conversation->toArray();
        $conversationArray['lastMessageDate'] = $lastMessage ?
            $lastMessage->getCreatedAt()->format('d.m.Y H:i') : '';

        return $conversationArray;
    }
}
