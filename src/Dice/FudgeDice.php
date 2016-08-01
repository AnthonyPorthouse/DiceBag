<?php
namespace DiceBag\Dice;

use DiceBag\Randomization\Randomization;

class FudgeDice extends AbstractDice
{
    public function __construct(Randomization $randomization)
    {
        parent::__construct($randomization);

        $this->value = $this->randomization->getValue(-1, 1);
    }
}
