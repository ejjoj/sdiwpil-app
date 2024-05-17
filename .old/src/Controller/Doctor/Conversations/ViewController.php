<?php

namespace App\Controller\Doctor\Conversations;

use App\Service\Vuex\Module\DoctorChatsModule;
use App\Service\Vuex\StateGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ViewController extends AbstractController
{
    /**
     * @Route("/doctor/chats", name="front.doctor.chats")
     */
    public function index(StateGenerator $stateGenerator, DoctorChatsModule $doctorChatsModule): Response
    {
        $stateGenerator->addToStateModules($doctorChatsModule);

        return $this->render('doctor/chats.html.twig', $stateGenerator->getState());
    }
}
