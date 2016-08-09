<?php
namespace DiceBag\Modifiers;

use DiceBag\Dice\DiceFactory;
use DiceBag\Dice\DiceInterface;

class Exploding extends BaseModifier implements Modifier
{
    const MATCH = '/!(?<condition><|>)?(?<from>\d*)/';

    /** {@inheritdoc} */
    public function apply(array $dice, DiceFactory $factory) : array
    {
        preg_match(static::MATCH, $this->format, $matches);
        $explodeOn = null;
        if (!empty($matches['from'])) {
            $explodeOn = $matches['from'];
        }

        $condition = 'eq';
        if (!empty($matches['condition'])) {
            $condition = $matches['condition'];
        }

        $newDice = [];

        /** @var DiceInterface $die */
        foreach ($dice as $die) {
            $explodeOn = $explodeOn ?? $die->max();

            while ($this->conditionCheck($condition, $die->value(), $explodeOn)) {
                $newDice[] = $die = $factory->makeDice("d" . $die->max())[0];
            }
        }

        return array_merge($dice, $newDice);
    }

    private function conditionCheck(string $condition, int $value, int $conditionValue) : bool
    {
        if ($condition === '<') {
            return $value <= $conditionValue;
        } elseif ($condition === '>') {
            return $value >= $conditionValue;
        }

        return $value === $conditionValue;
    }
}
