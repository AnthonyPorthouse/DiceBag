<?php
namespace DiceBag\Modifiers;

interface Modifier
{
    public function isValid() : bool;

    /**
     * @param Dice[] $dice
     *
     * @return Dice[]
     */
    public function apply(array $dice) : array;
}
