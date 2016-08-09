<?php
namespace DiceBag\Dice;

use DiceBag\Randomization\RandomizationEngine;

class FudgeDice extends AbstractDice
{
    const FORMAT = '/^(?<quantity>\d*)dF/i';

    /**
     * FudgeDice constructor.
     *
     * @param RandomizationEngine $randomization
     */
    public function __construct(RandomizationEngine $randomization)
    {
        parent::__construct($randomization);

        $this->min = -1;
        $this->max = 1;

        $this->value = $this->randomization->getValue($this->min, $this->max);
    }

    /** {@inheritdoc} */
    public static function make(RandomizationEngine $randomization, string $diceString) : array
    {
        preg_match(static::FORMAT, $diceString, $tokens);

        $pool = [];

        for ($i = 0; $i < ($tokens['quantity'] ?: 1); $i++) {
            $pool[] = new static($randomization);
        }

        return $pool;
    }
}
