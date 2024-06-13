<?php

namespace App\Controller;

use App\Entity\User;
use App\Exception\BadRequestException;
use App\Model\Response\ResponseModel;
use App\Service\Controller\Api\RegisterController\DataValidator;
use App\Service\Entity\User\UserConverter;
use App\Service\Mail\WelcomingEmailBuilder;
use App\Service\Response\ErrorResponseStrategyResolver;
use App\Service\Response\SuccessResponseBuilder;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegisterController extends AbstractController
{
    public function __construct(
        private readonly DataValidator $dataValidator,
        private readonly ErrorResponseStrategyResolver $errorResponseStrategyResolver,
        private readonly SuccessResponseBuilder $successResponseBuilder,
        private readonly TranslatorInterface $translator,
        private readonly UserConverter $userConverter,
        private readonly EntityManagerInterface $entityManager,
        private readonly WelcomingEmailBuilder $welcomingEmailBuilder,
        private readonly MessageBusInterface $messageBus,
    ) {
    }

    #[Route('/register', methods: 'POST')]
    public function __invoke(Request $request): JsonResponse
    {
        try {
            $decoded = json_decode($request->getContent(), true);
            $this->validatePayload($decoded);
            $user = $this->getConvertedUser($decoded);
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $this->sendWelcomingEmail($user);
            $response = $this->getSuccessResponse();
        } catch (\Throwable $exception) {
            $response = $this->getErrorResponse($exception);
        } finally {
            return $this->json($response->getResponseData()->toArray(), $response->getStatusCode());
        }
    }

    /**
     * @throws BadRequestException
     */
    public function validatePayload(mixed $decoded): void
    {
        $this->dataValidator
            ->withData($decoded ?? [])
            ->validate();
    }

    public function getConvertedUser(array $decoded): User
    {
        return $this->userConverter
            ->withPayload($decoded)
            ->convert();
    }

    private function sendWelcomingEmail(User $user): void
    {
        $message = $this->welcomingEmailBuilder
            ->withUser($user)
            ->build();
        $this->messageBus->dispatch($message);
    }

    private function getSuccessResponse(): ResponseModel
    {
        return $this->successResponseBuilder
            ->withMessage($this->translator->trans('success.register'))
            ->build();
    }

    private function getErrorResponse(\Exception $exception): ResponseModel
    {
        return $this->errorResponseStrategyResolver
            ->withException($exception)
            ->resolve()
            ->get();
    }
}
