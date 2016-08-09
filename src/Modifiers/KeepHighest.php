<?php
namespace DiceBag\Modifiers;

use DiceBag\Dice\DiceFactory;

class KeepHighest extends BaseModifier
{
    const MATCH = '/kh(?<highest>\d+)/i';

    private $highest;

    /** {@inheritdoc} */
    public function apply(array $dice, DiceFactory $factory) : array
    {
        preg_match(static::MATCH, $this->format, $matches);
        $this->highest = (int) $matches['highest'];

        sort($dice);

        return array_slice($dice, 0 - $this->highest);
    }

    /** {@inheritdoc} */
    public function __toString() : string
    {
        return "Keep the Highest " . $this->highest . " Dice";
    }
}
