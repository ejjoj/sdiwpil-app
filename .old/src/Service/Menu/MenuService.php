<?php

namespace App\Service\Menu;

use App\Service\Menu\Item\DoctorMenuItem;
use App\Service\Menu\Item\ManagementMenuItem;
use App\Service\Menu\Item\PatientMenuItem;
use App\Service\Menu\Item\ReceptionistMenuItem;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Cache\Adapter\AdapterInterface;

class MenuService
{
    public function __construct(private readonly AdapterInterface $cache)
    {
    }

    public function getMenu(): array
    {
        if ($this->isMenuCached()) {
            return $this->getCachedMenu();
        }

        $menu = new ArrayCollection();
        $patientMenuItem = new PatientMenuItem();
        $doctorMenuItem = new DoctorMenuItem();
        $receptionistMenuItem = new ReceptionistMenuItem();
        $managementMenuItem = new ManagementMenuItem();

        $patientMenuItem
            ->setNextItem($doctorMenuItem)
            ->setNextItem($receptionistMenuItem)
            ->setNextItem($managementMenuItem);
        $patientMenuItem->addToMenu($menu);
        $menuArray = $menu->toArray();
        $this->saveCachedMenu($menuArray);

        return $menuArray;
    }

    private function isMenuCached(): bool
    {
       return $this->cache->getItem($this->getMenuCacheKey())->isHit();
    }

    private function getMenuCacheKey(): string
    {
        return md5('sdiwpil.main.menu');
    }

    private function getCachedMenu(): array
    {
        return $this->cache->getItem($this->getMenuCacheKey())->get();
    }

    private function saveCachedMenu(array $menuArray): void
    {
        $cachedMenu = $this->cache->getItem($this->getMenuCacheKey())->set($menuArray)->expiresAfter(300);
        $this->cache->save($cachedMenu);
    }
}
