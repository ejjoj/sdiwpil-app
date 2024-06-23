<?php

declare(strict_types=1);

namespace App\Controller\Profile;

use App\Form\DoctorProfileType;
use App\Service\Authorization\PermissionValidator;
use App\Service\Authorization\UserFlyweight;
use App\Service\Error\ErrorsConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/profile')]
class CreateController extends AbstractController
{
    public function __construct(
        private readonly PermissionValidator $permissionValidator,
        private readonly UserFlyweight $userFlyweight,
        private readonly ErrorsConverter $errorsConverter,
    ) {
    }

    #[Route('/create', methods: ['POST'])]
    public function index(Request $request): JsonResponse
    {
        try {
            $token = $request->headers->get('authorization');
            $this->permissionValidator->validate($token);
            $content = $request->getContent();
            $payload = json_decode($content, true);
            unset($payload['customerId']);
            $payload['customerId'] = $this->userFlyweight->getUser($token)->getId();
            $form = $this->createForm(DoctorProfileType::class);
            $form->submit($payload);
            if (!$form->isValid()) {
                $errors = $this->errorsConverter->withForm($form)->convert();
                // TODO: move to assertion
            }
        } catch (\Throwable $throwable) {
            dd($throwable);
        }
        // TODO: handle creation
        return $this->json([
            'message' => 'Create doctor profile',
        ]);
    }
}
