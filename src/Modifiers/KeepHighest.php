<?php
namespace DiceBag\Modifiers;

class KeepHighest extends BaseModifier implements Modifier
{
    const MATCH = '/kh(?<highest>\d+)/';

    /** {@inheritdoc} */
    public function apply(array $dice) : array
    {
        preg_match(static::MATCH, $this->format, $matches);
        $highest = $matches['highest'];

        sort($dice);

        return array_slice($dice, 0 - $highest);
    }
}
