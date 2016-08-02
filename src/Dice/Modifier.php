<?php
namespace DiceBag\Dice;

use DiceBag\Randomization\Randomization;

class Modifier extends AbstractDice implements DiceInterface
{
    const FORMAT = '/^(?<value>\d+)$/';

    public function __construct(Randomization $randomization, string $modifier)
    {
        parent::__construct($randomization);

        $this->value = (int) $modifier;
    }

    public static function make(Randomization $randomization, string $diceString) : array
    {
        preg_match(static::FORMAT, $diceString, $tokens);

        return [new static($randomization, $tokens['value'])];
    }

    public function __toString() : string
    {
        return $this->value();
    }
}
