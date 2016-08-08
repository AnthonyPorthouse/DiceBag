<?php
namespace DiceBag\Dice;

use DiceBag\Randomization\RandomizationEngine;

abstract class AbstractDice implements DiceInterface, \JsonSerializable
{
    const FORMAT = '//';

    /** @var int $min */
    protected $min;
    /** @var int $max */
    protected $max;

    /** @var int $value */
    protected $value;

    /** @var RandomizationEngine $randomization */
    protected $randomization;

    public function __construct(RandomizationEngine $randomization)
    {
        $this->randomization = $randomization;
    }

    public function min() : int
    {
        return $this->min;
    }

    public function max() : int
    {
        return $this->max;
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

    public function jsonSerialize()
    {
        return [
            'min' => $this->min(),
            'max' => $this->max(),
            'result' => $this->value(),
        ];
    }

    public function __toString()
    {
        return '[' . $this->value() . ']';
    }
}
