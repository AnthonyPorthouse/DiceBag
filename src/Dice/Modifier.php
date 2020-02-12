<?php

declare(strict_types=1);

namespace DiceBag\Dice;

use DiceBag\Randomization\RandomizationEngine;

final class Modifier extends AbstractDice
{
    protected const FORMAT = '/^(?<value>-?\d+)$/i';

    /**
     * Modifier constructor.
     *
     * @param RandomizationEngine $randomization
     * @param string $modifier
     */
    public function __construct(RandomizationEngine $randomization, string $modifier)
    {
        parent::__construct($randomization);

        $modifier = (int) $modifier;

        $this->min = $modifier;
        $this->max = $modifier;

        $this->value = $modifier;
    }

    /** {@inheritdoc} */
    public static function make(RandomizationEngine $randomization, string $diceString) : array
    {
        preg_match(static::FORMAT, $diceString, $tokens);

        return [new static($randomization, $tokens['value'])];
    }

    /** {@inheritdoc} */
    public function __toString() : string
    {
        return (string)$this->value();
    }
}
