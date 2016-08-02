<?php
namespace DiceBag\Dice;

use DiceBag\Randomization\Randomization;

class DiceFactory
{
    /** @var Randomization $randomizationEngine */
    private $randomizationEngine;

    public function __construct(Randomization $randomizationEngine)
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
