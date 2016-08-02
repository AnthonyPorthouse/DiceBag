<?php
namespace DiceBag\Dice;

use DiceBag\Randomization\RandomizationEngine;

abstract class AbstractDice implements DiceInterface
{
    const FORMAT = '//';

    /** @var int $value */
    protected $value;

    /** @var RandomizationEngine $randomization */
    protected $randomization;

    public function __construct(RandomizationEngine $randomization)
    {
        $this->randomization = $randomization;
    }

    public function value() : int
    {
        return $this->value;
    }

    /**
     * @param string $diceString
     *
     * @return bool
     */
    public static function isValid(string $diceString) : bool
    {
        return preg_match(static::FORMAT, $diceString);
    }

    public function __toString()
    {
        return '[' . $this->value() . ']';
    }
}
