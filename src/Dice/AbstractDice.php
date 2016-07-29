<?php
namespace DiceBag\Dice;

abstract class AbstractDice implements DiceInterface
{
    /** @var int $value */
    protected $value;

    public function value() : int
    {
        return $this->value;
    }

    public function __toString()
    {
        return '[' . $this->value() . ']';
    }
}
