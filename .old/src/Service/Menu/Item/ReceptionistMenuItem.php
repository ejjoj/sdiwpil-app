<?php

namespace App\Service\Menu\Item;

use App\Model\Menu\MenuItemModel;
use Doctrine\Common\Collections\ArrayCollection;

class ReceptionistMenuItem extends AbstractMenuItem
{
    public function addToMenu(ArrayCollection $menu): void
    {
        $menu->add(new MenuItemModel(
            'front.receptionist.dashboard',
            'Recepcja',
            'mdi-account-group'
        ));

        parent::addToMenu($menu);
    }
}
