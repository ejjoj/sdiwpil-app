<?php

namespace App\Controller;

use App\Entity\Conversation;
use App\Service\Menu\MenuService;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Utils;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

abstract class AbstractParticularConversationController extends AbstractController
{
    protected Conversation $conversation;

    abstract public function index(string $channelId): Response;

    abstract protected function getHeader(): string;

    abstract protected function getTemplatePath(): string;

    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly MenuService $menuService
    ) {
    }

    protected function setConversation(string $channelId): void
    {
        $conversation = $this->entityManager->getRepository(Conversation::class)
            ->findOneBy(['channelId' => $channelId]);
        if (!$conversation) {
            throw $this->createNotFoundException();
        }

        $this->conversation = $conversation;
    }

    protected function getFrontEndMessages(): array
    {
        foreach ($this->conversation->getMessages() as $message) {
            $result[] = $message->toArray();
        }

        return $result ?? [];
    }

    #[ArrayShape([
        'pageTitle' => "string",
        'state' => "string",
        'menu' => "array",
    ])] protected function getState(): array
    {
        // TODO: Make a state model out of it.
        return [
            'pageTitle' => $this->getHeader(),
            'state' => Utils::jsonEncode([
                'messages' => $this->getFrontEndMessages(),
                'conversation' => $this->conversation->getId(),
                'userId' => $this->getUser()->getId(),
                'routeScreenHeader' => $this->getHeader(),
                'menu' => $this->menuService->getMenu(),
            ]),
        ];
    }
}
