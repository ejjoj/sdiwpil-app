<?php

namespace App\Controller;

use App\Service\Vuex\Module\HomePageModule;
use App\Service\Vuex\StateGenerator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomePageViewController extends AbstractController
{
    /**
     * @Route("/", name="front.home_page")
     */
    public function __invoke(StateGenerator $stateGenerator, HomePageModule $homePageModule): Response
    {
        $stateGenerator->addToStateModules($homePageModule);

        return $this->render('home_page/index.html.twig', $stateGenerator->getState());
    }
}
