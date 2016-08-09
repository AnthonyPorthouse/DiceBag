<?php
namespace DiceBag\Dice;

use DiceBag\Randomization\RandomizationEngine;

class DiceFactory
{
    /** @var RandomizationEngine $randomizationEngine */
    private $randomizationEngine;

    const DICE_TYPES = [
        Dice::class,
        FudgeDice::class,
        Modifier::class,
    ];

    /**
     * DiceFactory constructor.
     *
     * @param RandomizationEngine $randomizationEngine
     */
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
        foreach (self::DICE_TYPES as $type) {
            if ($type::isValid($diceString)) {
                return $type::make($this->randomizationEngine, $diceString);
            }
        }

        return [];
    }
}
