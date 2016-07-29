<?php
namespace DiceBag\Dice;

class Dice extends AbstractDice
{
    /**
     * Dice constructor.
     *
     * @param int $size
     */
    public function __construct(int $size)
    {
        $this->value = (int) mt_rand(1, $size);
    }
}
