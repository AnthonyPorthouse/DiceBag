<?php
namespace DiceBag\Modifiers;

class DropLowest extends BaseModifier implements Modifier
{
    protected $match = '/dl(?<lowest>\d+)/';

    /** {@inheritdoc} */
    public function apply(array $dice) : array
    {
        preg_match($this->getMatch(), $this->format, $matches);
        $lowest = $matches['lowest'];

        sort($dice);

        return array_slice($dice, $lowest);
    }
}
