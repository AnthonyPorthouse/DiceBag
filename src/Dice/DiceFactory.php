<?php
namespace DiceBag\Dice;

use DiceBag\Randomization\RandomizationEngine;

class DiceFactory
{
    /** @var RandomizationEngine $randomizationEngine */
    private $randomizationEngine;

    public function __construct(RandomizationEngine $randomizationEngine)
    {
        $this->randomizationEngine = $randomizationEngine;
    }

    /**
     * @param string $diceString
     *
     * @return DiceInterface[]
     */
    public function makeDice(string $diceString) : array
    {
        $types = [
            Dice::class,
            FudgeDice::class,
            Modifier::class,
        ];

        foreach ($types as $type) {
            if ($type::isValid($diceString)) {
                return $type::make($this->randomizationEngine, $diceString);
            }
        }

        return [];
    }
}
