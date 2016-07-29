<?php
namespace DiceBag\Dice;

class DiceFactory
{
    const DICE_FORMAT = '/(?<quantity>\d*)(?<type>d|f)(?<size>\d*)/';

    /**
     * @param string $diceString
     * @return DiceInterface[]
     */
    public function makeDice(string $diceString) : array
    {
        $tokens = [];

        preg_match(self::DICE_FORMAT, $diceString, $tokens);

        switch ($tokens['type'] ?? null) {
            case 'd':
                $method = 'makeBasicDice';
                break;
            case 'f':
                $method = 'makeFudgeDice';
                break;
            default:
                return [$this->makeModifier($diceString)];
        }

        $pool = [];
        for ($i = 0; $i < ($tokens['quantity'] ?: 1); $i++) {
            $pool[] = $this->$method($tokens['size']);
        }

        return $pool;
    }

    private function makeBasicDice(int $size) : DiceInterface
    {
        return new Dice($size);
    }

    private function makeFudgeDice() : DiceInterface
    {
        return new FudgeDice;
    }

    private function makeModifier(int $value) : DiceInterface
    {
        return new Modifier($value);
    }
}
