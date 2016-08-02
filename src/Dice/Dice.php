<?php
namespace DiceBag\Dice;

use DiceBag\Randomization\Randomization;

class Dice extends AbstractDice
{
    const FORMAT = '/^(?<quantity>\d*)d(?<size>\d+)/';

    /**
     * Dice constructor.
     *
     * @param Randomization $randomization
     * @param int $size
     */
    public function __construct(Randomization $randomization, int $size)
    {
        parent::__construct($randomization);

        $this->value = $this->randomization->getValue(1, $size);
    }

    public static function make(Randomization $randomization, string $diceString) : array
    {
        preg_match(static::FORMAT, $diceString, $tokens);

        $pool = [];

        for ($i = 0; $i < ($tokens['quantity'] ?: 1); $i++) {
            $pool[] = new static($randomization, $tokens['size']);
        }

        return $pool;
    }
}
