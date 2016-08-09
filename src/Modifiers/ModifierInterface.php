<?php
namespace DiceBag\Modifiers;

use DiceBag\Dice\DiceFactory;
use DiceBag\Dice\DiceInterface;

interface ModifierInterface
{
    /**
     * Checks if a modifier is valid for the current dice format
     *
     * @param string $diceFormat The dice format to check if is valid for this modifier
     *
     * @return bool
     */
    public static function isValid(string $diceFormat) : bool;

    /**
     * Applies this modifier to this dice pool
     *
     * @param DiceInterface[] $dice The dice to apply the modifier to
     * @param DiceFactory $diceFactory The dice factory in case additional dice need to be added to the pool
     *
     * @return DiceInterface[]
     */
    public function apply(array $dice, DiceFactory $diceFactory) : array;
}
