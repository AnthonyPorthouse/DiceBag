<?php
namespace DiceBag\Modifiers;

use DiceBag\Dice\DiceFactory;

class DropLowest extends BaseModifier
{
    const MATCH = '/dl(?<lowest>\d+)/i';

    /** {@inheritdoc} */
    public function apply(array $dice, DiceFactory $factory) : array
    {
        preg_match(static::MATCH, $this->format, $matches);
        $lowest = $matches['lowest'];

        sort($dice);

        return array_slice($dice, $lowest);
    }
}
