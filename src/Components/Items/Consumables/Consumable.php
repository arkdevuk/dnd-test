<?php

namespace App\Components\Items\Consumables;

use App\Components\Items\Item;

abstract class Consumable extends Item
{
    public const CONSUMABLE_HEALTH = "health";
    public const CONSUMABLE_MANA = "mana";

    /**
     * @var int : Food power
     */
    protected int $amount;
    /**
     * @var string : Food type
     */
    protected string $type;
    /**
     * @var bool : If food is used
     */
    protected bool $used;

    public function __construct(string $name, string $description,
        string $type = self::CONSUMABLE_HEALTH)
    {
        parent::__construct($name, $description,
            false, Item::CAT_CONSUMABLE);
        $this->type = $type;
        $this->used = false;
        $this->amount = 20;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @param int $amount
     * @return Consumable
     */
    public function setAmount(int $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Consumable
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return bool
     */
    public function isUsed(): bool
    {
        return $this->used;
    }

    /**
     * @param bool $used
     * @return Consumable
     */
    public function setUsed(bool $used): self
    {
        $this->used = $used;

        return $this;
    }
}