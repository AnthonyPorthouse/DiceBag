<?php
namespace DiceBag\Dice;

use DiceBag\Randomization\RandomizationEngine;

class Modifier extends AbstractDice implements DiceInterface
{
    const FORMAT = '/^(?<value>\d+)$/';

    public function __construct(RandomizationEngine $randomization, string $modifier)
    {
        parent::__construct($randomization);

        $this->min = (int) $modifier;
        $this->max = (int) $modifier;

        $this->value = (int) $modifier;
    }

    public static function make(RandomizationEngine $randomization, string $diceString) : array
    {
        preg_match(static::FORMAT, $diceString, $tokens);

        return [new static($randomization, $tokens['value'])];
    }

    public function __toString() : string
    {
        return $this->value();
    }
}
