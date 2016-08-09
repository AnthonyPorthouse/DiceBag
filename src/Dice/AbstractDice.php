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

    /**
     * AbstractDice constructor.
     *
     * @param RandomizationEngine $randomization
     */
    public function __construct(RandomizationEngine $randomization)
    {
        $this->randomization = $randomization;
    }

    /** {@inheritdoc} */
    public function min() : int
    {
        return $this->min;
    }

    /** {@inheritdoc} */
    public function max() : int
    {
        return $this->max;
    }

    /** {@inheritdoc} */
    public function value() : int
    {
        return $this->value;
    }

    /** {@inheritdoc} */
    public static function isValid(string $diceString) : bool
    {
        return preg_match(static::FORMAT, $diceString);
    }

    /** {@inheritdoc} */
    public function jsonSerialize() : array
    {
        return [
            'min' => $this->min(),
            'max' => $this->max(),
            'result' => $this->value(),
        ];
    }

    /**
     * Returns a String representation of the dice
     *
     * @return string
     */
    public function __toString() : string
    {
        return '[' . $this->value() . ']';
    }
}
