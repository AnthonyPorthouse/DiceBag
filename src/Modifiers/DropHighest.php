<?php
namespace DiceBag\Modifiers;

use DiceBag\Dice\DiceFactory;

class DropHighest extends BaseModifier
{
    const MATCH = '/dh(?<highest>\d+)/i';

    /** @var int $highest */
    private $highest;

    /** {@inheritdoc} */
    public function apply(array $dice, DiceFactory $factory) : array
    {
        preg_match(static::MATCH, $this->format, $matches);
        $this->highest = $matches['highest'];

        sort($dice);

        return array_slice($dice, 0, 0 - $this->highest);
    }

    /** {@inheritdoc} */
    public function __toString() : string
    {
        return "Drop the Highest " . $this->highest . " Dice";
    }
}
