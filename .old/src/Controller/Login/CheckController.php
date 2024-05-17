<?php

namespace App\Controller\Login;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CheckController extends AbstractController
{
    /**
     * @Route(
     *     "/login/check",
     *     name="front.login.check",
     *     methods={"POST"},
     * )
     */
    public function index(): void
    {
    }
}
