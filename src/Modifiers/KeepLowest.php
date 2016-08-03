<?php
namespace DiceBag\Modifiers;

use DiceBag\Dice\DiceInterface;

class KeepLowest extends BaseModifier implements Modifier
{
    const MATCH = '/kl(?<lowest>\d+)/';

    /** {@inheritdoc} */
    public function apply(array $dice) : array
    {
        preg_match(static::MATCH, $this->format, $matches);
        $lowest = $matches['lowest'];

        sort($dice);

        return array_slice($dice, 0, $lowest);
    }
}
