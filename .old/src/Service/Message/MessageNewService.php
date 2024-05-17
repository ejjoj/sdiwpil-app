<?php

namespace App\Service\Message;

use App\Entity\Message;
use App\Form\Message\MessageBulkType;
use App\Service\FormErrorService;
use App\Service\RequestService;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use GuzzleHttp\Utils;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;

class MessageNewService extends RequestService
{
    private const SUCCESS = 'success';
    private const ERRORS = 'errors';

    private array $result = [
        self::SUCCESS => false,
        self::ERRORS => [],
    ];

    public function __construct(
        RequestStack $requestStack,
        private readonly FormFactoryInterface $formFactory,
        private readonly FormErrorService $formErrorService,
        private readonly EntityManagerInterface $entityManager,
        private readonly LoggerInterface $logger
    ) {
        parent::__construct($requestStack);
    }

    public function getJsonResponse(): JsonResponse
    {
        $this->processValidation();

        return new JsonResponse($this->result);
    }

    /**
     * @param Message[] $messages
     */
    private function saveMessages(array $messages): void
    {
        foreach ($messages as $message) {
            $conversation = $message->getConversation();
            $conversation->addMessage($message);
            $this->entityManager->persist($message);
            $this->entityManager->persist($conversation);
        }

        $this->entityManager->flush();
    }

    private function processValidation(): void
    {
        try {
            $form = $this->formFactory->create(MessageBulkType::class)->submit(
                Utils::jsonDecode($this->request->getContent(), true)
            );
            if ($form->isValid()) {
                $this->saveMessages($form->get(MessageBulkType::MESSAGES)->getData());
                $this->result[self::SUCCESS] = true;
            } else {
                $this->result[self::ERRORS] = $this->formErrorService->getArray($form);
            }
        } catch (Exception $exception) {
            $this->result[self::ERRORS][] = ['message' => 'Something went wrong, try again'];
            $this->logger->error($exception->getMessage());
        }
    }
}
