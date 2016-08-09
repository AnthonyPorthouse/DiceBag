<?php
namespace DiceBag\Modifiers;

use DiceBag\Dice\DiceFactory;
use DiceBag\Dice\DiceInterface;

class Exploding extends BaseModifier
{
    const MATCH = '/!(?<condition><|>)?(?<from>\d*)/i';

    /** @var int $explodeOn */
    private $explodeOn;
    /** @var string $condition */
    private $condition;

    /** {@inheritdoc} */
    public function apply(array $dice, DiceFactory $factory) : array
    {
        preg_match(static::MATCH, $this->format, $matches);

        $explodeOn = $matches['from'] ?? null;
        $condition = $matches['condition'] ?? 'eq';

        $newDice = [];

        /** @var DiceInterface $die */
        foreach ($dice as $die) {
            $explodeOn = $explodeOn ?: $die->max();

            $this->explodeOn = (int) $explodeOn;
            $this->condition = $condition;

            while ($this->conditionCheck($condition, $die->value(), $explodeOn)) {
                $newDice[] = $die = $factory->makeDice("d" . $die->max())[0];
            }
        }

        return array_merge($dice, $newDice);
    }

    /**
     * Checks if the value matches the condition against the conditions value
     *
     * @param string $condition the condition we're trying
     * @param int $value The value to check
     * @param int $conditionValue The conditions value to check against
     *
     * @return bool true if the value matches the condition against the condition value, false otherwise
     */
    private function conditionCheck(string $condition, int $value, int $conditionValue) : bool
    {
        if ($condition === '<') {
            return $value <= $conditionValue;
        } elseif ($condition === '>') {
            return $value >= $conditionValue;
        }

        return $value === $conditionValue;
    }

    /** {@inheritdoc} */
    public function __toString() : string
    {
        $condition = '=';
        if ($this->condition === '<') {
            $condition = '<=';
        } elseif ($this->condition === '>') {
            $condition = '>=';
        }

        return "Dice explode when result is " . $condition . " " . $this->explodeOn;
    }
}
