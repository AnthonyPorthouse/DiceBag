<?php
namespace DiceBag\Modifiers;

use DiceBag\Dice\DiceFactory;

class KeepHighest extends BaseModifier
{
    const MATCH = '/kh(?<highest>\d+)/';

    /** {@inheritdoc} */
    public function apply(array $dice, DiceFactory $factory) : array
    {
        preg_match(static::MATCH, $this->format, $matches);
        $highest = $matches['highest'];

        sort($dice);

        return array_slice($dice, 0 - $highest);
    }
}
