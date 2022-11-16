<?php

namespace App\Components\Dungeons;

use App\Components\Characters\Foes\Foe;
use App\Components\Characters\Foes\Goblin;
use App\Components\Characters\Pets\Creatures\Dog;
use App\Components\Utils\ProbabilityPicker;

class Room
{

    protected int $roomLevel = 1;
    /**
     * @var array|Foe[]
     */
    protected array $monsters = [];
    // todo generate room and monsters in the room
    // todo add a bag to the room with random loot
    //
    protected int $amountOfMonsters;

    public function __construct(int $roomLevel)
    {
        $this->roomLevel = $roomLevel;
        $this->amountOfMonsters = random_int(1, (ceil($roomLevel / 10) + 1));

        $this->generateMonsters();
    }

    public function getNarrative(): void
    {
        echo 'You enter a room'.PHP_EOL;
        echo 'You see '.$this->amountOfMonsters.' monsters'.PHP_EOL;
        // todo decrrire les monstres

        // todo decrire le loot
    }

    public function generateMonsters(): void
    {
        $arrayMonstersSpawnable = [
            [
                'probability' => .8,
                'data' => [
                    'class' => Goblin::class,
                    'construct' => [
                        'name' => 'Gobuku',
                    ],
                    'spawner' => function (Goblin $goblin) {
                        $goblin->setLife(random_int(10, 15));
                        $goblin->setPhyPower(random_int(10, 15));
                        $goblin->addXp($this->roomLevel * 100);

                        return $goblin;
                    },
                ],
            ],
            [
                'probability' => .2,
                'data' => [
                    'class' => Goblin::class,
                    'construct' => [
                        'name' => 'Guard',
                    ],
                    'spawner' => function (Goblin $goblin) {
                        $goblin->setLife(random_int(30, 60));
                        $goblin->setPhyPower(random_int(5, 10));
                        $goblin->addXp($this->roomLevel * 100);

                        return $goblin;
                    },
                ],
            ],
            [
                'probability' => .05,
                'data' => [
                    'class' => Goblin::class,
                    'construct' => [
                        'name' => 'Goblin king',
                    ],
                    'spawner' => function (Goblin $goblin) {
                        $goblin->setLife(random_int(50, 70));
                        $goblin->setPhyPower(random_int(30, 50));
                        $goblin->addXp(($this->roomLevel * 100) + 1);

                        return $goblin;
                    },
                ],
            ],
        ];


        $pp = new ProbabilityPicker($arrayMonstersSpawnable);

        echo "Room level: ".$this->roomLevel.PHP_EOL;
        echo "Amount of monsters: ".$this->amountOfMonsters.PHP_EOL;
        for ($i = 0; $i < $this->amountOfMonsters; $i++) {
            $monsterDataSrc = $pp->pickItem();
            $monsterData = $monsterDataSrc['data'];

            $monsterData['construct']['name'] .= ' #'.($i + 1);

            $monster = new $monsterData['class'](...$monsterData['construct']);

            if (isset($monsterData['spawner'])) {
                $this->monsters[] = $monsterData['spawner']($monster);
            } else {
                $this->monsters[] = $monster;
            }
        }

        //var_dump($this->monsters);
    }
}