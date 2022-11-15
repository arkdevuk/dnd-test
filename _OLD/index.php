<?php

abstract class Character
{
    /**
     * @var string : Character name
     */
    protected string $name;
    /**
     * @var DateTime : Creation date
     */
    protected DateTime $creationDate;
    /**
     * @var int : Physical power stat
     */
    protected int $phyPower;
    /**
     * @var int : Magical power stat
     */
    protected int $magPower;
    /**
     * @var int : Armor stat
     */
    protected int $armor;
    /**
     * @var int : Dodge stat
     */
    protected int $escape;
    /**
     * @var int : HP stat
     */
    protected int $life;
    /**
     * @var int : MP stat
     */
    protected int $mana;
    /**
     * @var Weapon|null : equipped weapon
     */
    protected ?Weapon $weapon;
    /**
     * @var Shield|null : equipped shield
     */
    protected ?Shield $shield;
    /**
     * @var Bag : backpack
     */
    protected Bag $inventory;
    /**
     * @var string : character class
     */
    protected string $classe;
    /**
     * @var array : equipable weapons
     */
    protected array $equipableWeapon = [];
    /**
     * @var bool : Can equip shield
     */
    protected bool $hasShield;

    public function __construct(
        string $name,
        string $classe
    )
    {
        $this->name = $name;
        $this->creationDate = new \DateTime();
        $this->phyPower = 10;
        $this->magPower = 10;
        $this->armor = 10;
        $this->escape = 10;
        $this->life = 10;
        $this->mana = 10;
        $this->weapon = null;
        $this->shield = null;
        $this->inventory = new Bag(24);
        $this->classe = $classe;
        $this->equipableWeapon = [];
        $this->hasShield = false;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Character
     */
    public function setName(string $name): Character
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreationDate(): DateTime
    {
        return $this->creationDate;
    }

    /**
     * @param DateTime $creationDate
     * @return Character
     */
    public function setCreationDate(DateTime $creationDate): Character
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * @return int
     */
    public function getPhyPower(): int
    {
        return $this->phyPower;
    }

    /**
     * @param int $phyPower
     * @return Character
     */
    public function setPhyPower(int $phyPower): Character
    {
        $this->phyPower = $phyPower;

        return $this;
    }

    /**
     * @return int
     */
    public function getMagPower(): int
    {
        return $this->magPower;
    }

    /**
     * @param int $magPower
     * @return Character
     */
    public function setMagPower(int $magPower): Character
    {
        $this->magPower = $magPower;

        return $this;
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
     * @return Character
     */
    public function setArmor(int $armor): Character
    {
        $this->armor = $armor;

        return $this;
    }

    /**
     * @return int
     */
    public function getEscape(): int
    {
        return $this->escape;
    }

    /**
     * @param int $escape
     * @return Character
     */
    public function setEscape(int $escape): Character
    {
        $this->escape = $escape;

        return $this;
    }

    /**
     * @return int
     */
    public function getLife(): int
    {
        return $this->life;
    }

    /**
     * @param int $life
     * @return Character
     */
    public function setLife(int $life): Character
    {
        $this->life = $life;

        return $this;
    }

    /**
     * @return int
     */
    public function getMana(): int
    {
        return $this->mana;
    }

    /**
     * @param int $mana
     * @return Character
     */
    public function setMana(int $mana): Character
    {
        $this->mana = $mana;

        return $this;
    }

    /**
     * @return Weapon|null
     */
    public function getWeapon(): ?Weapon
    {
        return $this->weapon;
    }

    /**
     * @param Weapon|null $weapon
     * @return Character
     */
    public function setWeapon(?Weapon $weapon): Character
    {
        $this->weapon = $weapon;

        return $this;
    }

    /**
     * @return Shield|null
     */
    public function getShield(): ?Shield
    {
        return $this->shield;
    }

    /**
     * @param Shield|null $shield
     * @return Character
     */
    public function setShield(?Shield $shield): Character
    {
        $this->shield = $shield;

        return $this;
    }

    /**
     * @return Bag
     */
    public function getInventory(): Bag
    {
        return $this->inventory;
    }

    /**
     * @param Bag $inventory
     * @return Character
     */
    public function setInventory(Bag $inventory): Character
    {
        $this->inventory = $inventory;

        return $this;
    }

    /**
     * @return string
     */
    public function getClasse(): string
    {
        return $this->classe;
    }

    /**
     * @param string $classe
     * @return Character
     */
    public function setClasse(string $classe): Character
    {
        $this->classe = $classe;

        return $this;
    }

    public function useItem(Item $item): void
    {
        if ($item instanceof Potion && $item->isUsed() === false) {
            // ====>
            if ($item->getType() === Potion::POTION_HEALTH) {
                $this->life += $item->getAmount();
                if ($this->life > 100) {
                    $this->life = 100;
                }
            } elseif ($item->getType() === Potion::POTION_MANA) {
                $this->mana += $item->getAmount();
                if ($this->mana > 100) {
                    $this->mana = 100;
                }
            }
            $item->setUsed(true);
            echo $this->getName() . " used " . $item->getName() . " and now has " . $this->getLife() . " HP and " . $this->getMana() . " MP" . PHP_EOL;
        }
        // TODO Personnage->useItem(Item $item)
    }

    // TODO - [public] useItem(Item $item) => if item.equipable === false

    public function canEquip(Item $item): bool
    {
        if ($item instanceof Weapon) {
            return in_array($item->getWeaponClass(), $this->equipableWeapon, true);
        }

        if (($item instanceof Shield) && $this->hasShield === true) {
            return true;
        }
        if($item instanceof Shield && $this->getWeapon()->isTwoHanded() === false) {
            return true;
        }
        if($item instanceof Weapon && $item->isTwoHanded() === true) {
            $this->unequipItem($this->isHasShield());
        }
    }

    /**
     * @throws Exception
     */
    public function equipItem(Item $item): void
    {
        if (!$this->getInventory()->hasItem($item)) {
            throw new \RuntimeException("You don't have this item in your inventory");
        }

        if ($this->canEquip($item) === false) {
            throw new \RuntimeException("You can't equip this item");
        }
        echo $this->getName() . " equip " . $item->getName() . PHP_EOL;

        // TODO - [public] equipItem (Item $item) => if item.equipable === true
    }

    public function unequipItem(Item $item): void
    {
        if ($item instanceof Weapon) {
            $this->setWeapon(null);
        }
        elseif ($item instanceof Shield) {
            $this->setShield(null);
        }
    }

    public function receiveDamage(int $damage): void
    {
        $this->life -= $damage;
        if ($this->life < 0) {
            $this->life = 0;
        }
        echo $this->name . " received " . $damage . " damage and now has " . $this->life . " life points left" . PHP_EOL;
        // TODO [public] receiveDamage(int $damage) : recevoir des dégats => code pour calculer les dégats
        // TODO $target->receiveDamage($damage);
    }

    public function attackTarget(Character $target): void
    {
        $damage = $this->phyPower;
        if ($this->weapon !== null) {
            $damage += $this->weapon->getDamage();
        }
        $target->receiveDamage($damage);
        // TODO - [public] attackTarget(Personnage $target) : attaquer un personnage => code pour calculer les dégats et l'utilisation de mana
    }

    // TODO $damage = [calcul des dmg];

    // private function isDodged(): bool
    // {
    //     // TODO - [private] isDodged() : calculer si le personnage a esquivé l'attaque mt_rand(0,  (escape - 100)) === (escape - 100)
    // }

    public function isAlive(): bool
    {
        if($this->life <= 0) {
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function getEquipableWeapon(): array
    {
        return $this->equipableWeapon;
    }

    /**
     * @param array $equipableWeapon
     * @return Character
     */
    public function setEquipableWeapon(array $equipableWeapon): Character
    {
        $this->equipableWeapon = $equipableWeapon;

        return $this;
    }

    /**
     * @return bool
     */
    public function isHasShield(): bool
    {
        return $this->hasShield;
    }

    /**
     * @param bool $hasShield
     * @return Character
     */
    public function setHasShield(bool $hasShield): Character
    {
        $this->hasShield = $hasShield;

        return $this;
    }
}

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
     * @throws Exception
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
        var_dump($this);
        return $this;
    }

    // TODO use ID to store item in array

    public function removeItem(Item $item): Bag
    {

    }

    // TODO removeItem(Item $item): Bag

    public function hasItem(Item $item): bool
    {
        return in_array($item, $this->item, true);
    }
    // TODO use ID to check
}

class Warrior extends Character
{

    /**
     * @throws Exception
     */
    public function __construct(string $name)
    {
        parent::__construct($name, 'Warrior');
        $this->setLife(100);
        $this->setMana(0);
        $this->setPhyPower(random_int(60, 80));
        $this->setMagPower(0);
        $this->setEscape(random_int(1, 100));
        $this->setEquipableWeapon([Weapon::CLASS_SWORD, Weapon::CLASS_AXE, Weapon::CLASS_SPEAR, Weapon::CLASS_HAMMER, Weapon::CLASS_FIST]);
        $this->setHasShield(true);
    }
}

class Mage extends Character
{
    /**
     * @throws Exception
     */
    public function __construct(string $name)
    {
        parent::__construct($name, 'Mage');
        $this->setLife(60);
        $this->setMana(100);
        $this->setPhyPower(0);
        $this->setMagPower(random_int(60, 80));
        $this->setEscape(random_int(20, 100));
        $this->setEquipableWeapon([Weapon::CLASS_STAFF, Weapon::CLASS_WAND, Weapon::CLASS_FIST]);
    }
}

class Rogue extends Character
{
    /**
     * @throws Exception
     */
    public function __construct(string $name)
    {
        parent::__construct($name, 'Rogue');
        $this->setLife(80);
        $this->setMana(0);
        $this->setPhyPower(random_int(20, 50));
        $this->setMagPower(0);
        $this->setEscape(random_int(50, 100));
        $this->setEquipableWeapon([Weapon::CLASS_SWORD, Weapon::CLASS_DAGGER, Weapon::CLASS_BOW, Weapon::CLASS_FIST]);
    }
}

abstract class Foe extends Character
{
    public const RACE_GOBLIN = 'goblin';
    public const RACE_ORC = 'orc';
    public const RACE_BAT = 'bat';
    public const RACE_SKELETON = 'skeleton';
    public const RACE_ZOMBIE = 'zombie';

    protected string $race;

    public function __construct(string $name, string $race)
    {
        parent::__construct($name, 'Foe');
        $this->setRace($race);
    }


// TODO nom random, stats random
// TODO Foe : bat|zombie|orc|goblin|skeleton
// TODO each Foe override attackTarget(Character $target) => code pour calculer les dégats et l'utilisation de mana
    /**
     * @return string
     */
    public function getRace(): string
    {
        return $this->race;
    }

    /**
     * @param string $race
     * @return Foe
     */
    public function setRace(string $race): Foe
    {
        $this->race = $race;

        return $this;
    }

}
class Goblin extends Foe
{
    /**
     * @throws Exception
     */
    public function __construct(string $name)
    {
        parent::__construct($name, Foe::RACE_GOBLIN);
        $this->setLife(random_int(20, 40));
        $this->setMana(random_int(0, 20));
        $this->setPhyPower(random_int(20, 50));
        $this->setMagPower(random_int(10, 30));
        $this->setEscape(random_int(50, 100));
        $this->setEquipableWeapon([Weapon::CLASS_SWORD, Weapon::CLASS_DAGGER, Weapon::CLASS_BOW, Weapon::CLASS_FIST], Weapon::CLASS_STAFF, Weapon::CLASS_WAND);
    }
}

abstract class Item
{
    public const CAT_WEAPON = 'weapon';
    public const CAT_SHIELD = 'shield';
    public const CAT_ARMOR = 'armor';
    public const CAT_POTION = 'potion';
    public const CAT_FOOD = 'food';
    public const CAT_KEY = 'key';
    public const CAT_QUEST = 'quest';
    public const CAT_MISC = 'misc';

    /**
     * @var string : Item name
     */
    protected string $name;
    /**
     * @var string : Item description
     */
    protected string $description;
    /**
     * @var bool : If item is equipable
     */
    protected bool $equipable;
    /**
     * @var string : Item category
     */
    protected string $category;
    /**
     * @var ?string : Item id
     */
    protected ?string $id;

    /**
     * @throws Exception
     */
    public function __construct(
        string $name,
        string $description,
        bool   $equipable,
        string $category = self::CAT_MISC,
    )
    {
        $this->name = $name;
        $this->description = $description;
        $this->equipable = $equipable;
        $this->category = $category;
        $this->id = microtime() . random_int(100, 999);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Item
     */
    public function setName(string $name): Item
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Item
     */
    public function setDescription(string $description): Item
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEquipable(): bool
    {
        return $this->equipable;
    }

    /**
     * @param bool $equipable
     * @return Item
     */
    public function setEquipable(bool $equipable): Item
    {
        $this->equipable = $equipable;

        return $this;
    }

    /**
     * @return string
     */
    public function getCategory(): string
    {
        return $this->category;
    }

    /**
     * @param string $category
     * @return Item
     */
    public function setCategory(string $category): Item
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string|null $id
     * @return Item
     */
    public function setId(?string $id): Item
    {
        $this->id = $id;

        return $this;
    }
}

class Weapon extends Item
{
    public const CLASS_SWORD = 'sword';
    public const CLASS_AXE = 'axe';
    public const CLASS_DAGGER = 'dagger';
    public const CLASS_BOW = 'bow';
    public const CLASS_STAFF = 'staff';
    public const CLASS_WAND = 'wand';
    public const CLASS_SPEAR = 'spear';
    public const CLASS_HAMMER = 'hammer';
    public const CLASS_FIST = 'fist';

    protected int $damage;
    protected bool $isTwoHanded;
    protected string $weaponclass;

    public function __construct(
        string $name,
        string $description,
        bool   $equipable,
        string $category,
        int    $damage,
        bool   $isTwoHanded,
        string $weaponclass
    )
    {
        parent::__construct($name, $description, $equipable, $category);
        $this->damage = $damage;
        $this->isTwoHanded = $isTwoHanded;
        $this->weaponclass = $weaponclass;
    }

    /**
     * @return int
     */
    public function getDamage(): int
    {
        return $this->damage;
    }

    /**
     * @param int $damage
     * @return Weapon
     */
    public function setDamage(int $damage): Weapon
    {
        $this->damage = $damage;

        return $this;
    }

    /**
     * @return bool
     */
    public function isTwoHanded(): bool
    {
        return $this->isTwoHanded;
    }

    /**
     * @param bool $isTwoHanded
     * @return Weapon
     */
    public function setIsTwoHanded(bool $isTwoHanded): Weapon
    {
        $this->isTwoHanded = $isTwoHanded;

        return $this;
    }

    /**
     * @return string
     */
    public function getWeaponclass(): string
    {
        return $this->weaponclass;
    }

    /**
     * @param string $weaponclass
     * @return Weapon
     */
    public function setWeaponclass(string $weaponclass): Weapon
    {
        $this->weaponclass = $weaponclass;

        return $this;
    }

}

class Sword extends Weapon
{
    public function __construct(
        string $name,
        string $description,
        int    $damage,
        bool   $isTwoHanded,
    )
    {
        parent::__construct($name, $description, true, Item::CAT_WEAPON, $damage, $isTwoHanded, Weapon::CLASS_SWORD);
    }
}

class Axe extends Weapon
{
    public function __construct(
        string $name,
        string $description,
        int    $damage,
        bool   $isTwoHanded,
    )
    {
        parent::__construct($name, $description, true, Item::CAT_WEAPON, $damage, $isTwoHanded, Weapon::CLASS_AXE);
    }
}

class Dagger extends Weapon
{
    public function __construct(
        string $name,
        string $description,
        int    $damage,
    )
    {
        parent::__construct($name, $description, true, Item::CAT_WEAPON, $damage, false, Weapon::CLASS_DAGGER);
    }
}

class Bow extends Weapon
{
    public function __construct(
        string $name,
        string $description,
        int    $damage,
    )
    {
        parent::__construct($name, $description, true, Item::CAT_WEAPON, $damage, true, Weapon::CLASS_BOW);
    }
}

class Staff extends Weapon
{
    public function __construct(
        string $name,
        string $description,
        int    $damage,
    )
    {
        parent::__construct($name, $description, true, Item::CAT_WEAPON, $damage, true, Weapon::CLASS_STAFF);
    }
}

class Wand extends Weapon
{
    public function __construct(
        string $name,
        string $description,
        int    $damage,
    )
    {
        parent::__construct($name, $description, true, Item::CAT_WEAPON, $damage, false, Weapon::CLASS_WAND);
    }
}

class Spear extends Weapon
{
    public function __construct(
        string $name,
        string $description,
        int    $damage,
    )
    {
        parent::__construct($name, $description, true, Item::CAT_WEAPON, $damage, true, Weapon::CLASS_SPEAR);
    }
}

class Hammer extends Weapon
{
    public function __construct(
        string $name,
        string $description,
        int    $damage,
        bool   $isTwoHanded,
    )
    {
        parent::__construct($name, $description, true, Item::CAT_WEAPON, $damage, $isTwoHanded, Weapon::CLASS_HAMMER);
    }
}

class Fist extends Weapon
{
    public function __construct(
        string $name,
        string $description,
        int    $damage,
    )
    {
        parent::__construct($name, $description, true, Item::CAT_WEAPON, $damage, false, Weapon::CLASS_FIST);
    }
}

class Shield extends Item
{
    protected string $name;
    protected int $armor;

    public function __construct(
        string $name,
        string $description,
        int    $armor,
    )
    {
        parent::__construct($name, $description, true, Item::CAT_SHIELD);
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
     * @return Shield
     */
    public function setArmor(int $armor): Shield
    {
        $this->armor = $armor;

        return $this;
    }
}



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

class Potion extends Item
{
    public const POTION_HEALTH = "heal";
    public const POTION_MANA = "mana";

    /**
     * @var int : Potion power
     */
    protected int $amount;
    /**
     * @var string : Potion type
     */
    protected string $type;
    /**
     * @var bool : If potion is used
     */
    protected bool $used;

    public function __construct($name, $description, string $type = self::POTION_HEALTH)
    {
        parent::__construct($name, $description, false, Item::CAT_POTION);
        $this->type = $type;
        $this->used = false;
        $this->amount = 50;
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
     * @return Potion
     */
    public function setAmount(int $amount): Potion
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
     * @return Potion
     */
    public function setType(string $type): Potion
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
     * @return Potion
     */
    public function setUsed(bool $used): Potion
    {
        $this->used = $used;

        return $this;
    }
}

class Food extends Item
{
    public const FOOD_MEAT = "meat";
    public const FOOD_FRUIT = "fruit";

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

    public function __construct($name, $description, string $type = self::FOOD_MEAT)
    {
        parent::__construct($name, $description, false, Item::CAT_FOOD);
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
     * @return Food
     */
    public function setAmount(int $amount): Food
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
     * @return Food
     */
    public function setType(string $type): Food
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
     * @return Food
     */
    public function setUsed(bool $used): Food
    {
        $this->used = $used;

        return $this;
    }
}

class Key extends Item
{
    public const KEY_DOOR = "door";
    public const KEY_CHEST = "chest";

    /**
     * @var string : Key type
     */
    protected string $type;

    public function __construct($name, $description, string $type = self::KEY_DOOR)
    {
        parent::__construct($name, $description, false, Item::CAT_KEY);
        $this->type = $type;
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
     * @return Key
     */
    public function setType(string $type): Key
    {
        $this->type = $type;

        return $this;
    }
}

class QuestItem extends Item
{
    public const QUEST_ITEM = "quest";

    /**
     * @var string : Quest item type
     */
    protected string $type;

    public function __construct($name, $description, string $type = self::QUEST_ITEM)
    {
        parent::__construct($name, $description, false, Item::CAT_QUEST);
        $this->type = $type;
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
     * @return QuestItem
     */
    public function setType(string $type): QuestItem
    {
        $this->type = $type;

        return $this;
    }
}

class Misc extends Item
{
    public const MISC_ITEM = "misc";

    /**
     * @var string : Misc item type
     */
    protected string $type;

    public function __construct($name, $description, string $type = self::MISC_ITEM)
    {
        parent::__construct($name, $description, false);
        $this->type = $type;
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
     * @return Misc
     */
    public function setType(string $type): Misc
    {
        $this->type = $type;

        return $this;
    }
}

try {
    $axeOfDeath = new Axe('Axe of Death', 'Axe of Death', 30, true);
} catch (Exception $e) {
}
try {
    $shieldOfLife = new Shield('Shield of Life', 'Shield of DLife', 20);
} catch (Exception $e) {
}

$maxiHealthPotion = new Potion('Maxi Health Potion', 'Turbo Health Potion Deluxe');

$gobugobu = new Goblin("Gobugobu");
$abrutus = new Warrior("Abrutus");
$gandolfr = new Mage("Gandolfr");
$saskue = new Rogue("Saskue");

try {
    $abrutus->getInventory()->addItem($maxiHealthPotion);
} catch (Exception $e) {
}
// ...
$abrutus->receiveDamage(50);
// ...
$abrutus->useItem($maxiHealthPotion);


var_dump($abrutus, '______________', $gandolfr, '______________', $saskue, '______________', $gobugobu);