<?php
namespace DiceBag\Modifiers;

use DiceBag\Dice\DiceFactory;

class DropLowest extends BaseModifier
{
    const MATCH = '/dl(?<lowest>\d+)/i';

    /** @var int $lowest */
    private $lowest;

    /** {@inheritdoc} */
    public function apply(array $dice, DiceFactory $factory) : array
    {
        preg_match(static::MATCH, $this->format, $matches);
        $this->lowest = (int) $matches['lowest'];

        sort($dice);

        return array_slice($dice, $this->lowest);
    }

    /** {@inheritdoc} */
    public function __toString() : string
    {
        return "Drop the Lowest " . $this->lowest . " Dice";
    }
}
