<?php
namespace DiceBag\Modifiers;

class DropLowest extends BaseModifier implements Modifier
{
    const MATCH = '/dl(?<lowest>\d+)/';

    /** {@inheritdoc} */
    public function apply(array $dice) : array
    {
        preg_match(static::MATCH, $this->format, $matches);
        $lowest = $matches['lowest'];

        sort($dice);

        return array_slice($dice, $lowest);
    }
}
