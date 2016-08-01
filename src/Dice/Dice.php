<?php
namespace DiceBag\Dice;

use DiceBag\Randomization\Randomization;

class Dice extends AbstractDice
{
    /**
     * Dice constructor.
     *
     * @param Randomization $randomization
     * @param int $size
     */
    public function __construct(Randomization $randomization, int $size)
    {
        parent::__construct($randomization);

        $this->value = $this->randomization->getValue(1, $size);
    }
}
