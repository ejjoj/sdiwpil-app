<?php

namespace App\Service\Menu\Item;

use Doctrine\Common\Collections\ArrayCollection;

abstract class AbstractMenuItem
{
    protected ?AbstractMenuItem $nextItem;

    public function addToMenu(ArrayCollection $menu): void
    {
        $this->nextItem?->addToMenu($menu);
    }

    public function setNextItem(AbstractMenuItem $nextItem): AbstractMenuItem
    {
        $this->nextItem = $nextItem;

        return $this->nextItem;
    }
}
