<?php
namespace DiceBag\Modifiers;

class DropHighest extends BaseModifier implements Modifier
{
    const MATCH = '/dh(?<highest>\d+)/';

    /** {@inheritdoc} */
    public function apply(array $dice) : array
    {
        preg_match(static::MATCH, $this->format, $matches);
        $highest = $matches['highest'];

        sort($dice);

        return array_slice($dice, 0, 0 - $highest);
    }
}
