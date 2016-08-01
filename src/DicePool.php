<?php
namespace DiceBag;

use DiceBag\Dice\Dice;
use DiceBag\Dice\DiceFactory;
use DiceBag\Dice\DiceInterface;
use DiceBag\Modifiers\DropHighest;
use DiceBag\Modifiers\DropLowest;
use DiceBag\Modifiers\KeepHighest;
use DiceBag\Modifiers\KeepLowest;
use DiceBag\Modifiers\Modifier;

class DicePool
{
    /** @var DiceInterface[] $dice */
    private $dice = [];

    /** @var DiceInterface[] $originalDice */
    private $originalDice = [];

    /** @var string $format */
    private $format;

    /** @var Modifier[] $modifiers */
    private $modifiers;

    const POSSIBLE_MODIFIERS = [
        KeepHighest::class,
        KeepLowest::class,
        DropHighest::class,
        DropLowest::class,
    ];

    public function __construct(DiceFactory $factory, string $diceString)
    {
        $this->format = $diceString;

        $this->originalDice = $factory->makeDice($diceString);

        $modifiers = $this->setupModifiers(self::POSSIBLE_MODIFIERS);

        $this->modifiers = array_filter($modifiers);

        $this->dice = $this->applyModifiers($this->originalDice);
    }

    /**
     * @param string[] $modifiers An array of modifier class names
     *
     * @return Modifier[]
     */
    private function setupModifiers(array $modifiers) : array
    {
        /** @var Modifier[] $modifiers */
        $modifiers = array_map(function (string $modifierClass) {
            /** @var Modifier $modifier */
            $modifier = new $modifierClass($this->format);

            if (!$modifier instanceof Modifier) {
                return null;
            }

            if ($modifier->isValid()) {
                return $modifier;
            }
        }, $modifiers);

        return $modifiers;
    }

    /**
     * @param DiceInterface[] $dice
     *
     * @return DiceInterface[]
     */
    private function applyModifiers(array $dice) : array
    {
        /** @var DiceInterface[] $dice */
        $dice = array_reduce($this->modifiers, function (array $dice, Modifier $modifier) : array {
            return $modifier->apply($dice);
        }, $dice);

        return $dice;
    }

    /**
     * Returns the array of Dice
     *
     * @return DiceInterface[]
     */
    public function getDice() : array
    {
        return $this->dice;
    }

    /**
     * Gets the total result of the DicePool
     *
     * @return int
     */
    public function getTotal() : int
    {
        return array_reduce($this->dice, function (int $prev, DiceInterface $dice) {
            return $prev + $dice->value();
        }, 0);
    }

    public function __toString() : string
    {
        return '[' . implode(' ', $this->dice) . ' (' . $this->getTotal() . ')]';
    }
}
