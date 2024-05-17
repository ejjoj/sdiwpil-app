<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function __construct(
        private readonly FlashBagInterface $flashBag,
        private readonly UrlGeneratorInterface $router
    ) {
    }

    /**
     * @inheritDoc
     */
    public function handle(Request $request, AccessDeniedException $accessDeniedException): RedirectResponse
    {
        $this->flashBag->add('error', 'Nie masz uprawnień, by przejść do tej zawartości.');

        return new RedirectResponse($this->router->generate('front.home_page'));
    }
}
