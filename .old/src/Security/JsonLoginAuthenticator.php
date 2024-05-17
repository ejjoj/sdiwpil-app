<?php

namespace App\Security;

use App\Entity\User;
use GuzzleHttp\Utils;
use RuntimeException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

class JsonLoginAuthenticator extends AbstractAuthenticator implements AuthenticationEntryPointInterface
{
    public function __construct(private readonly UrlGeneratorInterface $urlGenerator)
    {
    }

    public function supports(Request $request): ?bool
    {
        return $request->getPathInfo() === '/login/check' && $request->isMethod('POST');
    }

    public function authenticate(Request $request): Passport
    {
        $params = Utils::jsonDecode($request->getContent(), true);

        return new Passport(
            new UserBadge($params['username'] ?? ''),
            new PasswordCredentials($params['password'] ?? '')
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new JsonResponse([
            'success' => true,
            'message' => 'Pomyślnie zalogowano się w systemie',
            'route' => $this->getRoute($token->getUser()),
        ]);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse([
            'success' => false,
            'message' => 'Nieprawidłowe dane logowania',
            'route' => '',
        ]);
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return new RedirectResponse($this->urlGenerator->generate('front.login'));
    }

    private function getRoute(?UserInterface $user): string
    {
        if (!$user) {
            throw new RuntimeException('Nie znaleziono użytkownika');
        }

        foreach ($user->getRoles() as $role) {
            if ($role === User::ROLE_USER) {
                continue;
            }

            return match ($role) {
                User::ROLE_PATIENT => $this->urlGenerator->generate('front.patient.dashboard'),
                User::ROLE_DOCTOR => $this->urlGenerator->generate('front.doctor.dashboard'),
                User::ROLE_RECEPTIONIST => $this->urlGenerator->generate('front.receptionist.dashboard'),
                User::ROLE_MANAGER => $this->urlGenerator->generate('front.manager.dashboard'),
                default => throw new RuntimeException('Nie znaleziono strefy podanego użytkownika'),
            };
        }

        throw new RuntimeException('Użytkownik nie ma przypisanej żadnej roli w systemie');
    }
}
