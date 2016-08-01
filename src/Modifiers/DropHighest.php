<?php
namespace DiceBag\Modifiers;

class DropHighest extends BaseModifier implements Modifier
{
    protected $match = '/dh(?<highest>\d+)/';

    /** {@inheritdoc} */
    public function apply(array $dice) : array
    {
        preg_match($this->getMatch(), $this->format, $matches);
        $highest = $matches['highest'];

        sort($dice);

        return array_slice($dice, 0, 0 - $highest);
    }
}
