<?php
namespace DiceBag;

use DiceBag\Dice\DiceFactory;
use DiceBag\Dice\DiceInterface;

class DicePool
{
    /** @var DiceInterface[] $pool */
    private $pool = [];

    public function __construct(string $diceString)
    {
        $diceFactory = new DiceFactory();

        $this->pool = $diceFactory->makeDice($diceString);
    }

    /**
     * Gets the total result of the DicePool
     *
     * @return int
     */
    public function getTotal() : int
    {
        return array_reduce($this->pool, function (int $prev, DiceInterface $dice) {
            return $prev + $dice->value();
        }, 0);
    }

    public function __toString() : string
    {
        return '[' . implode(' ', $this->pool) .  ' (' . $this->getTotal() . ')]';
    }
}
