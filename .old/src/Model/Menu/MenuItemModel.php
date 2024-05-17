<?php

namespace App\Model\Menu;

class MenuItemModel
{
    public function __construct(
        public string $route,
        public string $name,
        public string $icon
    ) {
    }
}
