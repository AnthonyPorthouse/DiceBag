<?php
namespace DiceBag\Modifiers;

class KeepHighest extends BaseModifier implements Modifier
{
    protected $match = '/kh(?<highest>\d+)/';

    public function apply(array $dice) : array
    {
        preg_match($this->getMatch(), $this->format, $matches);
        $highest = $matches['highest'];

        sort($dice);

        return array_slice($dice, 0 - $highest);
    }
}
