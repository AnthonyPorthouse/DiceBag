<?php
namespace DiceBag\Dice;

class DiceFactory
{
    const DICE_FORMAT = '/(?<quantity>\d*)(?<type>d|f)(?<size>\d*)/';

    /**
     * @param string $diceString
     *
     * @return DiceInterface[]
     */
    public function makeDice(string $diceString) : array
    {
        $tokens = [];

        preg_match(self::DICE_FORMAT, $diceString, $tokens);

        if (!isset($tokens['type'])) {
            return $this->makeModifier($diceString);
        }

        if ($tokens['type'] == 'd') {
            return $this->makeBasicDice($tokens['size'], $tokens['quantity'] ?: 1);
        }

        if ($tokens['type'] == 'f') {
            return $this->makeFudgeDice($tokens['quantity'] ?: 1);
        }
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
            $pool[] = new Dice($size);
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
            $pool[] = new FudgeDice();
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
