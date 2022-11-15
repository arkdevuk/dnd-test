<?php

namespace App\Components\Bags;

use App\Components\Items\Item;

class Bag
{
    /**
     * @var int : Item storage size
     */
    protected int $size;
    /**
     * @var array : Item list
     */
    protected array $item;

    public function __construct(int $size)
    {
        $this->size = $size;
        $this->item = [];
    }

    /**
     * @throws \Exception
     */
    public function addItem(Item $item): Bag
    {
//        foreach ($this->item as $items) {
//            $this->item[$items->getId()] = $item;
//        }

        if (count($this->item) < $this->size) {
            $this->item[] = $item;
        } else {
            throw new \RuntimeException("Your bag is full");
        }
        //var_dump($this);
        echo 'Item : ' . $item->getName() . ' added to bag' . PHP_EOL;
        return $this;
    }

    // TODO use ID to store item in array

    public function removeItem(Item $item): Bag
    {

        return $this;
    }

    // TODO removeItem(Item $item): Bag

    public function hasItem(Item $item): bool
    {
        return in_array($item, $this->item, true);
    }
    // TODO use ID to check
}