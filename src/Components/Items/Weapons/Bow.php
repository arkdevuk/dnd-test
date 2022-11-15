<?php

namespace App\Components\Items\Weapons;

use App\Components\Items\Item;

class Bow extends Weapon
{
    public function __construct(
        string $name,
        string $description,
        int    $damage,
    )
    {
        parent::__construct($name, $description, true,
            Item::CAT_WEAPON, $damage, true, Weapon::CLASS_BOW);
    }
}