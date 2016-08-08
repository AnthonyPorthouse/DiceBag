<?php
namespace DiceBag;

use DiceBag\Dice\DiceFactory;
use DiceBag\Randomization\MersenneTwister;
use DiceBag\Randomization\RandomizationEngine;

class DiceBag implements \JsonSerializable
{
    /** @var DicePool[] $dicePools */
    private $dicePools = [];

    /**
     * DiceBag constructor.
     *
     * @param array $diceStrings
     * @param RandomizationEngine $randomizationEngine
     */
    public function __construct(array $diceStrings, RandomizationEngine $randomizationEngine = null)
    {
        $randomizationEngine = $randomizationEngine ?? new MersenneTwister();

        $factory = new DiceFactory($randomizationEngine);

        $this->dicePools = array_map(function (string $diceString) use ($factory) {
            return new DicePool($factory, $diceString);
        }, $diceStrings);
    }

    /**
     * Creates a new instance of the DiceBag from a passed dice string.
     *
     * @param string $diceString The dice string to create the DiceBag for
     * @param RandomizationEngine $randomizationEngine
     *
     * @return DiceBag
     */
    public static function factory(string $diceString, RandomizationEngine $randomizationEngine = null) : DiceBag
    {
        $randomizationEngine = $randomizationEngine ?? new MersenneTwister();

        $diceString = strtolower($diceString);

        $diceStrings = explode('+', $diceString);

        return new DiceBag($diceStrings, $randomizationEngine);
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

    public function jsonSerialize()
    {
        return [
            'pools' => $this->getDicePools(),
            'total' => $this->getTotal(),
        ];
    }

    public function __toString() : string
    {
        return implode(' + ', $this->dicePools) . ' = ' . $this->getTotal();
    }
}
