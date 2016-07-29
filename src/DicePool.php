<?php
namespace DiceBag;

use DiceBag\Dice\DiceFactory;
use DiceBag\Dice\DiceInterface;

class DicePool
{
    /** @var DiceInterface[] $dice */
    private $dice = [];

    public function __construct(string $diceString)
    {
        $diceFactory = new DiceFactory();

        $this->dice = $diceFactory->makeDice($diceString);
    }

    /**
     * Returns the array of Dice
     *
     * @return DiceInterface[]
     */
    public function getDice() : array
    {
        return $this->dice;
    }

    /**
     * Gets the total result of the DicePool
     *
     * @return int
     */
    public function getTotal() : int
    {
        return array_reduce($this->dice, function (int $prev, DiceInterface $dice) {
            return $prev + $dice->value();
        }, 0);
    }

    public function __toString() : string
    {
        return '[' . implode(' ', $this->dice) . ' (' . $this->getTotal() . ')]';
    }
}
