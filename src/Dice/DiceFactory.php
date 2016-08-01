<?php
namespace DiceBag\Dice;

use DiceBag\Randomization\Randomization;

class DiceFactory
{
    const DICE_FORMAT = '/(?<quantity>\d*)(?<type>d|f)(?<size>\d*)/';

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
        $tokens = [];

        preg_match(self::DICE_FORMAT, $diceString, $tokens);

        if (!isset($tokens['type']) && !is_numeric($diceString)) {
            return [];
        } elseif (!isset($tokens['type']) && is_numeric($diceString)) {
            return $this->makeModifier($diceString);
        } elseif ($tokens['type'] == 'd') {
            return $this->makeBasicDice($tokens['size'], $tokens['quantity'] ?: 1);
        } elseif ($tokens['type'] == 'f') {
            return $this->makeFudgeDice($tokens['quantity'] ?: 1);
        }

        return [];
    }

    /**
     * @param int $size
     * @param int $quantity
     *
     * @return DiceInterface[]
     */
    private function makeBasicDice(int $size, int $quantity = 1) : array
    {
        $pool = [];
        for ($i = 0; $i < $quantity; $i++) {
            $pool[] = new Dice($this->randomizationEngine, $size);
        }
        return $pool;
    }

    /**
     * @param int $quantity
     *
     * @return DiceInterface[]
     */
    private function makeFudgeDice(int $quantity = 1) : array
    {
        $pool = [];
        for ($i = 0; $i < $quantity; $i++) {
            $pool[] = new FudgeDice($this->randomizationEngine);
        }
        return $pool;
    }

    /**
     * @param int $value
     *
     * @return DiceInterface[]
     */
    private function makeModifier(int $value) : array
    {
        return [new Modifier($value)];
    }
}
