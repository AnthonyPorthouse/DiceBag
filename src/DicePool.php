<?php
namespace DiceBag;

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

        $this->modifiers = array_map(function (string $modifierClass) {
            /** @var Modifier $modifier */
            $modifier = new $modifierClass($this->format);

            if (!$modifier instanceof Modifier) {
                return null;
            }

            if ($modifier->isValid()) {
                return $modifier;
            }
        }, self::POSSIBLE_MODIFIERS);

        $this->modifiers = array_filter($this->modifiers);

        $this->dice = array_reduce($this->modifiers, function (array $dice, Modifier $modifier) {
            return $modifier->apply($dice);
        }, $this->originalDice);
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
