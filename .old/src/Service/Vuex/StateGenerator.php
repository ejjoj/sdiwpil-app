<?php

namespace App\Service\Vuex;

use App\Service\Vuex\Module\AbstractModule;
use App\Service\Vuex\Module\MenuModule;
use Doctrine\Common\Collections\ArrayCollection;
use GuzzleHttp\Utils;
use JetBrains\PhpStorm\ArrayShape;

class StateGenerator
{
    /** @var ArrayCollection|AbstractModule[] */
    private ArrayCollection|array $stateModules;

    public function __construct(private readonly MenuModule $menuModule)
    {
        $this->stateModules = new ArrayCollection([$this->menuModule]);
    }

    public function addToStateModules(AbstractModule $module): void
    {
        if (!$this->stateModules->contains($module)) {
            $this->stateModules->add($module);
        }
    }

    #[ArrayShape(['state' => "array"])] public function getState(): array
    {
        $state = new ArrayCollection();
        foreach ($this->stateModules as $index => $module) {
            $module->setNextModule($this->stateModules[$index + 1] ?? null);
        }

        /** @var AbstractModule $firstModule */
        $firstModule = $this->stateModules->first();
        $firstModule->insertIntoState($state);

        return ['state' => Utils::jsonEncode($state->toArray())];
    }
}
