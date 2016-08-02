<?php
namespace DiceBag\Dice;

use DiceBag\Randomization\Randomization;

abstract class AbstractDice implements DiceInterface
{
    const FORMAT = '//';

    /** @var int $value */
    protected $value;

    /** @var Randomization $randomization */
    protected $randomization;

    public function __construct(Randomization $randomization)
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
