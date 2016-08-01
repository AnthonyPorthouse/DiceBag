<?php
namespace DiceBag\Dice;

use DiceBag\Randomization\Randomization;

abstract class AbstractDice implements DiceInterface
{
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

    public function __toString()
    {
        return '[' . $this->value() . ']';
    }
}
