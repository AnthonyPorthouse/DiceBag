<?php
namespace DiceBag;

use DiceBag\Dice\DiceFactory;
use DiceBag\Randomization\MersenneTwister;

class DiceBag
{
    /** @var DicePool[] $dicePools */
    private $dicePools = [];

    /**
     * DiceBag constructor.
     *
     * @param array $diceStrings
     */
    public function __construct(array $diceStrings)
    {
        $factory = new DiceFactory(new MersenneTwister());

        $this->dicePools = array_map(function (string $diceString) use ($factory) {
            return new DicePool($factory, $diceString);
        }, $diceStrings);
    }

    /**
     * Creates a new instance of the DiceBag from a passed dice string.
     *
     * @param string $diceString The dice string to create the DiceBag for
     *
     * @return DiceBag
     */
    public static function factory(string $diceString) : DiceBag
    {
        $diceString = strtolower($diceString);

        $diceStrings = explode('+', $diceString);

        return new DiceBag($diceStrings);
    }

    /**
     * Returns the array of DicePools
     *
     * @return DicePool[]
     */
    public function getDicePools() : array
    {
        return $this->dicePools;
    }

    /**
     * Gets the total value of a DicePool
     *
     * @return int
     */
    public function getTotal() : int
    {
        return array_reduce($this->dicePools, function (int $prev, DicePool $pool) {
            return $prev + $pool->getTotal();
        }, 0);
    }

    public function __toString() : string
    {
        return implode(' + ', $this->dicePools) . ' = ' . $this->getTotal();
    }
}
