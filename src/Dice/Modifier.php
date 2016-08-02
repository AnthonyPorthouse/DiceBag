<?php
namespace DiceBag\Dice;

use DiceBag\Randomization\Randomization;

class Modifier implements DiceInterface
{
    const FORMAT = '/(?<value>\d+)/';

    /** @var int $value */
    private $value;

    public function __construct(string $modifier)
    {
        $this->value = (int) $modifier;
    }

    /**
     * Returns the fixed modifiers value
     *
     * @return int
     */
    public function value() : int
    {
        return $this->value;
    }

    public static function isValid(string $diceString) : bool
    {
        return preg_match(static::FORMAT, $diceString);
    }

    public static function make(Randomization $randomization, string $diceString) : array
    {
        preg_match(static::FORMAT, $diceString, $tokens);

        return [new static($tokens['value'])];
    }

    public function __toString() : string
    {
        return $this->value();
    }
}
