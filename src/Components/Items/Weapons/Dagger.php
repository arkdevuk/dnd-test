<?php

namespace App\Components\Items\Weapons;

use App\Components\Items\Item;

class Dagger extends Weapon
{
    public function __construct(
        string $name,
        string $description,
        int    $damage,
    )
    {
        parent::__construct($name, $description, true,
            Item::CAT_WEAPON, $damage, false, Weapon::CLASS_DAGGER);
    }
}