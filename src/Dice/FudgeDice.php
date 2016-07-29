<?php
namespace DiceBag\Dice;

class FudgeDice extends AbstractDice
{
    /** @var int $value */
    protected $value;

    public function __construct()
    {
        $this->value = mt_rand(-1, 1);
    }
}
