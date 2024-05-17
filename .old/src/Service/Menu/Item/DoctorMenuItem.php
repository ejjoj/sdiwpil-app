<?php

namespace App\Service\Menu\Item;

use App\Controller\Doctor\Dashboard\ViewController;
use App\Model\Menu\MenuItemModel;
use Doctrine\Common\Collections\ArrayCollection;

class DoctorMenuItem extends AbstractMenuItem
{
    public function addToMenu(ArrayCollection $menu): void
    {
        $menu->add(new MenuItemModel(
            ViewController::ROUTE_NAME,
            'Lekarz',
            'mdi-doctor'
        ));

        parent::addToMenu($menu);
    }
}
