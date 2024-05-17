<?php

namespace App\Service\Settings;

use App\Entity\User;
use App\Form\Settings\UserSettingsFormType;
use App\Service\FormErrorService;
use Doctrine\ORM\EntityManagerInterface;
use GuzzleHttp\Utils;
use Psr\Log\LoggerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Security;

class UserSettingsSaveService
{
    private const SUCCESS_KEY = 'success';
    private const ERRORS_KEY = 'errors';

    protected static string $settingsFormType = UserSettingsFormType::class;

    private Request $request;

    private array $result = [
        self::SUCCESS_KEY => false,
        self::ERRORS_KEY => [],
    ];

    public function __construct(
        protected readonly EntityManagerInterface $entityManager,
        private readonly RequestStack $requestStack,
        private readonly FormFactoryInterface $formFactory,
        private readonly FormErrorService $formErrorService,
        private readonly Security $security,
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly LoggerInterface $logger,
    ) {
        $this->request = $this->getRequest();
    }

    public function getJsonResponse(): JsonResponse
    {
        $this->init();

        return new JsonResponse($this->result);
    }

    private function getRequest(): Request
    {
        $request = $this->requestStack->getCurrentRequest();
        if (!$request) {
            throw new \RuntimeException(sprintf('Request must be instance of %s', Request::class));
        }

        return $request;
    }

    private function init(): void
    {
        try {
            $this->handleForm();
        } catch (\Exception $exception) {
            $this->logger->error($exception->getMessage());
            $this->result[self::ERRORS_KEY][] = [
                'message' => 'Wystąpił błąd zapisania danych, spróbuj ponownie lub skontaktuj się z administratorem ' .
                    'systemu',
            ];
        }
    }

    private function getUser(): User
    {
        /** @var User $user */
        $user = $this->security->getUser();
        if (!$user) {
            throw new \RuntimeException(sprintf('User must be an instance of %s', User::class));
        }

        return $user;
    }

    private function handleEmailSave(User $user, array $data): void
    {
        $email = $data['email'] ?? '';
        if ($email) {
            $user->setEmail($email);
        }
    }

    private function handlePasswordSave(User $user, array $data): void
    {
        $password = $data['password'] ?? '';
        if ($password) {
            $hashedPassword = $this->passwordHasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);
        }
    }

    protected function populateUserData(User $user, array $data): void
    {
        $this->handleEmailSave($user, $data);
        $this->handlePasswordSave($user, $data);
    }

    private function handleForm(): void
    {
        $form = $this->formFactory->create(static::$settingsFormType)->submit(
            Utils::jsonDecode($this->request->getContent(), true)
        );
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $this->populateUserData($user, $form->getData());
            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $this->result[self::SUCCESS_KEY] = true;
        } else {
            $this->result[self::ERRORS_KEY] = $this->formErrorService->getArray($form);
        }
    }
}
