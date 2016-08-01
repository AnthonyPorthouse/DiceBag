<?php
namespace DiceBag\Modifiers;

use DiceBag\Dice\DiceInterface;

class KeepLowest extends BaseModifier implements Modifier
{
    protected $match = '/kl(?<lowest>\d+)/';

    /** {@inheritdoc} */
    public function apply(array $dice) : array
    {
        preg_match($this->getMatch(), $this->format, $matches);
        $lowest = $matches['lowest'];

        sort($dice);

        return array_slice($dice, 0, $lowest);
    }
}
