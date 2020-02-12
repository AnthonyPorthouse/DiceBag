<?php
namespace DiceBag\Modifiers;

use DiceBag\Dice\DiceFactory;

final class KeepLowest extends BaseDropKeep
{
    protected const MATCH = '/kl(?<match>\d+)/i';

    protected $keep = true;
    protected $highest = false;

    /** {@inheritdoc} */
    public function apply(array $dice, DiceFactory $factory) : array
    {
        $dice = parent::apply($dice, $factory);
        return array_slice($dice, 0, $this->match);
    }
}
