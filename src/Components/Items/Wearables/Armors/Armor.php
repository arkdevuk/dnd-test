<?php

namespace App\Components\Items\Wearables\Armors;


use App\Components\Items\Item;

class Armor extends Item
{
    protected string $name;
    protected int $armor;

    public function __construct(
        string $name,
        string $description,
        int    $armor,
    )
    {
        parent::__construct($name, $description, true, Item::CAT_ARMOR);
        $this->armor = $armor;
    }

    /**
     * @return int
     */
    public function getArmor(): int
    {
        return $this->armor;
    }

    /**
     * @param int $armor
     * @return Armor
     */
    public function setArmor(int $armor): Armor
    {
        $this->armor = $armor;

        return $this;
    }
}