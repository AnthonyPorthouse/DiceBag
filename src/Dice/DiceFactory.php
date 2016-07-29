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
                $pool = [];
                for ($i = 0; $i < ($tokens['quantity'] ?: 1); $i++) {
                    $pool[] = $this->makeBasicDice($tokens['size']);
                }

                return $pool;
                break;

            case 'f':
                $pool = [];
                for ($i = 0; $i < ($tokens['quantity'] ?: 1); $i++) {
                    $pool[] = $this->makeFudgeDice();
                }
                return $pool;
                break;

            default:
                return [new Modifier($diceString)];
        }
    }

    private function makeBasicDice(int $size) : DiceInterface
    {
        return new Dice($size);
    }

    private function makeFudgeDice() : DiceInterface
    {
        return new FudgeDice;
    }
}
