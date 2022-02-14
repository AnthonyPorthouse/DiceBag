<?php

declare(strict_types=1);

namespace DiceBag\Dice;

use DiceBag\Randomization\RandomizationEngine;

interface DiceInterface extends \Stringable
{
    /**
     * Returns the minimum value for the Dice
     *
     * @return int
     */
    public function min(): int;

    /**
     * Returns the maximum value for the Dice
     *
     * @return int
     */
    public function max(): int;

    /**
     * Returns the rolled value of the Dice
     *
     * @return int
     */
    public function value(): int;

    /**
     * Checks is the dice string is a valid format for this dice
     *
     * @param string $diceString
     *
     * @return bool
     */
    public static function isValid(string $diceString): bool;

    /**
     * Makes a dice of this type with the given dice string
     *
     * @param RandomizationEngine $randomization
     * @param string $diceString
     *
     * @return DiceInterface[]
     */
    public static function make(RandomizationEngine $randomization, string $diceString): array;
}
