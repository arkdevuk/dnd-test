<?php

namespace App\Components\Items\Consumables;

class Potion extends Consumable
{
    public const POTION_HEALTH = "heal";
    public const POTION_MANA = "mana";

    /**
     * @var string : type de potion utilisé pour l'affichage
     */
    protected string $potionType;

    public function __construct($name, $description,
        string $type = self::POTION_HEALTH)
    {
        $cType = Consumable::CONSUMABLE_HEALTH;
        if($type === self::POTION_MANA) {
            $cType = Consumable::CONSUMABLE_MANA;
        }
        parent::__construct($name, $description, $cType);
        $this->used = false;
        $this->potionType = $type;
        $this->amount = 50;
    }

    /**
     * @param string $potionType
     * @return Potion
     */
    public function setPotionType(string $potionType): Potion
    {
        $this->potionType = $potionType;

        return $this;
    }

    /**
     * @return string
     */
    public function getPotionType(): string
    {
        return $this->potionType;
    }
}