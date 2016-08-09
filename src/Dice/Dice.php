<?php
namespace DiceBag\Dice;

use DiceBag\Randomization\RandomizationEngine;

class Dice extends AbstractDice
{
    const FORMAT = '/^(?<quantity>\d*)d(?<size>\d+)/';

    /**
     * Dice constructor.
     *
     * @param RandomizationEngine $randomization
     * @param int $size
     */
    public function __construct(RandomizationEngine $randomization, int $size)
    {
        parent::__construct($randomization);

        $this->min = 1;
        $this->max = $size;

        $this->value = $this->randomization->getValue($this->min, $this->max);
    }

    /**
     * {@inheritdoc}
     */
    public static function make(RandomizationEngine $randomization, string $diceString) : array
    {
        preg_match(static::FORMAT, $diceString, $tokens);

        $pool = [];

        for ($i = 0; $i < ($tokens['quantity'] ?: 1); $i++) {
            $pool[] = new static($randomization, $tokens['size']);
        }

        return $pool;
    }
}
