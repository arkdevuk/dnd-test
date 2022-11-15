<?php

namespace App\Components\Items\Consumables;


class Food extends Consumable
{
    public const FOOD_MEAT = "meat"; // <3
    public const FOOD_FRUIT = "fruit"; // mana

    /**
     * @var string : type de food utilisé pour l'affichage
     */
    protected string $foodType;

    public function __construct($name, $description,
        string $type = self::FOOD_MEAT)
    {
        $cType = Consumable::CONSUMABLE_HEALTH;
        if($type === self::FOOD_FRUIT) {
            $cType = Consumable::CONSUMABLE_MANA;
        }
        parent::__construct($name, $description, $cType);
        $this->used = false;
        $this->foodType = $type;
        $this->amount = 25;
    }

    /**
     * @param string $foodType
     * @return Food
     */
    public function setFoodType(string $foodType): Food
    {
        $this->foodType = $foodType;

        return $this;
    }

    /**
     * @return string
     */
    public function getFoodType(): string
    {
        return $this->foodType;
    }
}