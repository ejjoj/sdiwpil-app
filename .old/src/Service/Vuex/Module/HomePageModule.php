<?php

namespace App\Service\Vuex\Module;

use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

class HomePageModule extends AbstractModule
{
    public function __construct(private readonly FlashBagInterface $flashBag)
    {
    }

    public function insertIntoState(ArrayCollection $state): void
    {
        $errors = [];
        foreach ($this->flashBag->get('error') as $error) {
            $errors[]['message'] = $error;
        }

        $state->set('home_page', ['errors' => $errors]);

        parent::insertIntoState($state);
    }
}
