<?php
namespace DiceBag\Modifiers;

use DiceBag\Dice\DiceFactory;
use DiceBag\Dice\DiceInterface;

interface Modifier
{
    /**
     * @param string $diceFormat The dice format to check if is valid for this modifier
     *
     * @return bool
     */
    public static function isValid(string $diceFormat) : bool;

    /**
     * @param DiceInterface[] $dice
     * @param DiceFactory $diceFactory
     *
     * @return array|\DiceBag\Dice\DiceInterface[]
     */
    public function apply(array $dice, DiceFactory $diceFactory) : array;
}
