<?php
namespace DiceBag\Modifiers;

use DiceBag\Dice\DiceInterface;

interface Modifier
{
    /**
     * @return bool
     */
    public function isValid() : bool;

    /**
     * @param DiceInterface[] $dice
     *
     * @return DiceInterface[]
     */
    public function apply(array $dice) : array;
}
