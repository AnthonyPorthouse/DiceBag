<?php
namespace DiceBag\Dice;

use DiceBag\Randomization\RandomizationEngine;

interface DiceInterface
{
    public function value() : int;

    public static function isValid(string $diceString) : bool;

    /**
     * @param RandomizationEngine $randomization
     * @param string $diceString
     *
     * @return DiceInterface[]
     */
    public static function make(RandomizationEngine $randomization, string $diceString) : array;
}
