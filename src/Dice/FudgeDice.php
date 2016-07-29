<?php
namespace DiceBag\Dice;

class FudgeDice extends AbstractDice
{
    public function __construct()
    {
        $this->value = mt_rand(-1, 1);
    }
}
