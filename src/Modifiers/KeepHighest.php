<?php
namespace DiceBag\Modifiers;

use DiceBag\Dice\DiceFactory;

class KeepHighest extends BaseDropKeep
{
    protected const MATCH = '/kh(?<match>\d+)/i';

    protected $keep = true;
    protected $highest = true;

    /** {@inheritdoc} */
    public function apply(array $dice, DiceFactory $factory) : array
    {
        $dice = parent::apply($dice, $factory);
        return array_slice($dice, 0 - $this->match);
    }
}
