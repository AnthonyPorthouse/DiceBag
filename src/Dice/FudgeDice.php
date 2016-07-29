<?php
namespace DiceBag\Dice;

class FudgeDice implements DiceInterface
{
    /** @var int $value */
    private $value;

    public function __construct()
    {
        $this->value = mt_rand(-1, 1);
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
