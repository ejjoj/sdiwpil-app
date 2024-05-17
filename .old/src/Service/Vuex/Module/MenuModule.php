<?php

namespace App\Service\Vuex\Module;

use App\Service\Menu\MenuService;
use Doctrine\Common\Collections\ArrayCollection;

class MenuModule extends AbstractModule
{
    public function __construct(private readonly MenuService $menuService)
    {
    }

    public function insertIntoState(ArrayCollection $state): void
    {
        $state->set('menu', ['items' => $this->menuService->getMenu()]);

        parent::insertIntoState($state);
    }
}
