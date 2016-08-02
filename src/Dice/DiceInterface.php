<?php
namespace DiceBag\Dice;

use DiceBag\Randomization\Randomization;

interface DiceInterface
{
    public function value() : int;

    public static function isValid(string $diceString) : bool;

    /**
     * @param Randomization $randomization
     * @param string $diceString
     *
     * @return DiceInterface[]
     */
    public static function make(Randomization $randomization, string $diceString) : array;
}
