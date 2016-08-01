<?php
namespace DiceBag\Modifiers;

class KeepLowest extends BaseModifier implements Modifier
{
    protected $match = '/kl(?<lowest>\d+)/';

    public function apply(array $dice) : array
    {
        preg_match($this->getMatch(), $this->format, $matches);
        $lowest = $matches['lowest'];

        sort($dice);

        return array_slice($dice, 0, $lowest);
    }
}
