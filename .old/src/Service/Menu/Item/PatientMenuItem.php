<?php

namespace App\Service\Menu\Item;

use App\Controller\Patient\Dashboard\ViewController;
use App\Model\Menu\MenuItemModel;
use Doctrine\Common\Collections\ArrayCollection;

class PatientMenuItem extends AbstractMenuItem
{
    public function addToMenu(ArrayCollection $menu): void
    {
        $menu->add(new MenuItemModel(
            ViewController::ROUTE_NAME,
            'Pacjent',
            'mdi-account'
        ));

        parent::addToMenu($menu);
    }
}
