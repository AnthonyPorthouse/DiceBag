<?php
namespace DiceBag\Modifiers;

use DiceBag\Dice\DiceFactory;

class DropHighest extends BaseModifier
{
    const MATCH = '/dh(?<highest>\d+)/';

    /** {@inheritdoc} */
    public function apply(array $dice, DiceFactory $factory) : array
    {
        preg_match(static::MATCH, $this->format, $matches);
        $highest = $matches['highest'];

        sort($dice);

        return array_slice($dice, 0, 0 - $highest);
    }
}
