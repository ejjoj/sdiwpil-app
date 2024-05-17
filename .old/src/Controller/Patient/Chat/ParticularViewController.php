<?php

namespace App\Controller\Patient\Chat;

use App\Controller\AbstractParticularConversationController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticularViewController extends AbstractParticularConversationController
{
    /**
     * @Route(
     *     "/patient/chat/{channelId}",
     *     name="front.patient.chat.particular",
     *     requirements={"channelId"="\w+"},
     * )
     */
    public function index(string $channelId): Response
    {
        $this->setConversation($channelId);

        return $this->render($this->getTemplatePath(), $this->getState());
    }

    protected function getHeader(): string
    {
        $doctor = $this->conversation->getDoctor()->getDoctor();

        return sprintf('Czat z lek. %s %s', $doctor->getFirstName(), $doctor->getLastName());
    }

    protected function getTemplatePath(): string
    {
        return 'patient/particular_chat.html.twig';
    }
}
