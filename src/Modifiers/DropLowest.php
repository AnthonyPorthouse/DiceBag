<?php
namespace DiceBag\Modifiers;

use DiceBag\Dice\DiceFactory;

final class DropLowest extends BaseDropKeep
{
    protected const MATCH = '/dl(?<match>\d+)/i';

    protected $keep = false;
    protected $highest = false;

    /** {@inheritdoc} */
    public function apply(array $dice, DiceFactory $factory) : array
    {
        $dice = parent::apply($dice, $factory);
        return array_slice($dice, $this->match);
    }
}
