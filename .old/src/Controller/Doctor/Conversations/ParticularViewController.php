<?php

namespace App\Controller\Doctor\Conversations;

use App\Controller\AbstractParticularConversationController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ParticularViewController extends AbstractParticularConversationController
{
    /**
     * @Route(
     *     "/doctor/chat/{channelId}",
     *     name="front.doctor.chat.particular",
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
        $patient = $this->conversation->getPatient()->getPatient();

        return sprintf('Czat z pacjentem %s %s', $patient->getFirstName(), $patient->getLastName());
    }

    protected function getTemplatePath(): string
    {
        return 'doctor/particular_chat.html.twig';
    }
}
