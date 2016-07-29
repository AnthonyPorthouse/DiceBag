<?php
namespace DiceBag;

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
        $this->dicePools = array_map(function(string $diceString) {
            return new DicePool($diceString);
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
     * Gets the total value of a DicePool
     *
     * @return int
     */
    public function getTotal() : int
    {
        return array_reduce($this->dicePools, function(int $prev, DicePool $pool) {
            return $prev + $pool->getTotal();
        }, 0);
    }

    public function __toString() : string
    {
        return implode(' + ', $this->dicePools) . ' = ' . $this->getTotal();
    }
}
