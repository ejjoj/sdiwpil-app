<?php

namespace App\Service\Vuex\Module;

use Doctrine\Common\Collections\ArrayCollection;

abstract class AbstractModule
{
    protected ?AbstractModule $nextModule;

    public function insertIntoState(ArrayCollection $state): void
    {
        $this->nextModule?->insertIntoState($state);
    }

    public function setNextModule(?AbstractModule $module): void
    {
        $this->nextModule = $module;
    }
}
