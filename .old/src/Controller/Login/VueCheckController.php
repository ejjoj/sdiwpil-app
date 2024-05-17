<?php

namespace App\Controller\Login;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class VueCheckController extends AbstractController
{
    /**
     * @Route(
     *     "/vue-login-check",
     *     name="front.vue.login_check",
     *     methods={"POST"},
     * )
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->json(['isLoggedIn' => (bool)$this->getUser()]);
    }
}
