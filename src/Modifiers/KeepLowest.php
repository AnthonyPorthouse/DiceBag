<?php
namespace DiceBag\Modifiers;

use DiceBag\Dice\DiceFactory;

class KeepLowest extends BaseModifier
{
    const MATCH = '/kl(?<lowest>\d+)/i';

    /** @var int $lowest */
    private $lowest;

    /** {@inheritdoc} */
    public function apply(array $dice, DiceFactory $factory) : array
    {
        preg_match(static::MATCH, $this->format, $matches);
        $this->lowest = $matches['lowest'];

        sort($dice);

        return array_slice($dice, 0, $this->lowest);
    }

    /** {@inheritdoc} */
    public function __toString() : string
    {
        return "Keep the Lowest " . $this->lowest . " Dice";
    }
}
