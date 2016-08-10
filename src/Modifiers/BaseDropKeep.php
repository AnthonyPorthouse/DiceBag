<?php
namespace DiceBag\Modifiers;

use DiceBag\Dice\DiceFactory;

abstract class BaseDropKeep extends BaseModifier
{
    /** @var int $match */
    protected $match;

    /** @var bool $keep True if dice are being kept */
    protected $keep;
    /** @var bool $highest True if We're affecting the highest */
    protected $highest;

    /** {@inheritdoc} */
    public function apply(array $dice, DiceFactory $factory) : array
    {
        preg_match(static::MATCH, $this->format, $matches);
        $this->match = (int) $matches['match'];

        sort($dice);

        return $dice;
    }

    /** {@inheritdoc} */
    public function __toString() : string
    {
        $keep = $this->keep ? 'Keep' : 'Drop';
        $highest = $this->highest ? 'Highest' : 'Lowest';
        return "{$keep} the {$highest} {$this->match} Dice";
    }
}
