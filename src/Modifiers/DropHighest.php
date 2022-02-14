<?php

declare(strict_types=1);

namespace DiceBag\Modifiers;

use DiceBag\Dice\DiceFactory;

final class DropHighest extends BaseDropKeep
{
    protected const MATCH = '/dh(?<match>\d+)/i';

    protected $keep = false;
    protected $highest = true;

    /** {@inheritdoc} */
    public function apply(array $dice, DiceFactory $factory): array
    {
        $dice = parent::apply($dice, $factory);
        return array_slice($dice, 0, 0 - $this->match);
    }
}
