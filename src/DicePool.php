<?php
namespace DiceBag;

use DiceBag\Dice\DiceFactory;
use DiceBag\Dice\DiceInterface;
use DiceBag\Exceptions\UnknownModifierException;
use DiceBag\Modifiers\DropHighest;
use DiceBag\Modifiers\DropLowest;
use DiceBag\Modifiers\Exploding;
use DiceBag\Modifiers\KeepHighest;
use DiceBag\Modifiers\KeepLowest;
use DiceBag\Modifiers\ModifierInterface;

class DicePool implements \JsonSerializable
{
    /** @var DiceInterface[] $dice */
    private $dice = [];

    /** @var DiceInterface[] $originalDice */
    private $originalDice = [];

    /** @var string $format */
    private $format;

    public const POSSIBLE_MODIFIERS = [
        Exploding::class,
        KeepHighest::class,
        KeepLowest::class,
        DropHighest::class,
        DropLowest::class,
    ];

    /** @var ModifierInterface[] $appliedModifiers */
    private $appliedModifiers;

    /**
     * DicePool constructor.
     *
     * @param DiceFactory $factory
     * @param string $diceString
     */
    public function __construct(DiceFactory $factory, string $diceString)
    {
        $this->format = $diceString;
        $this->originalDice = $factory->makeDice($diceString);

        $modifiers = $this->setupModifiers(self::POSSIBLE_MODIFIERS, $diceString);
        $modifiers = array_filter($modifiers);
        $this->dice = $this->applyModifiers($this->originalDice, $factory, $modifiers);
        $this->appliedModifiers = $modifiers;
    }

    /**
     * Sets up the modifiers for the dice string given
     *
     * @param string[] $modifiers An array of modifier class names
     * @param string $diceString The Dice String we're configuring the filers for
     *
     * @return ModifierInterface[]
     */
    private function setupModifiers(array $modifiers, string $diceString) : array
    {
        return array_map(static function (string $modifierClass) use ($diceString) {
            if (!is_a($modifierClass, ModifierInterface::class, true) || !$modifierClass::isValid($diceString)) {
                return null;
            }
            return new $modifierClass($diceString);
        }, $modifiers);
    }

    /**
     * Apply the modifiers to the dice String
     *
     * @param DiceInterface[] $dice
     * @param DiceFactory $diceFactory
     * @param ModifierInterface[] $modifiers
     *
     * @return DiceInterface[]
     */
    private function applyModifiers(array $dice, DiceFactory $diceFactory, array $modifiers) : array
    {
        /** @var DiceInterface[] $dice */
        $dice = array_reduce($modifiers, static function (array $dice, ModifierInterface $modifier) use ($diceFactory) : array {
            return $modifier->apply($dice, $diceFactory);
        }, $dice);

        return $dice;
    }

    /**
     * Get the Applied Modifiers
     *
     * @return ModifierInterface[]
     */
    public function getAppliedModifiers()
    {
        return array_values($this->appliedModifiers);
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
     * The Dice that were dropped.
     *
     * @return DiceInterface[]
     */
    public function getDroppedDice() : array
    {
        $pool = array_udiff($this->originalDice, $this->dice, function (DiceInterface $a, DiceInterface $b) {
            return strcmp(spl_object_hash($a), spl_object_hash($b));
        });

        return array_values($pool);
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

    /**
     * @return array<mixed>
     */
    public function jsonSerialize() : array
    {
        return [
            'appliedModifiers' => $this->getAppliedModifiers(),
            'dice' => $this->getDice(),
            'dropped' => $this->getDroppedDice(),
            'total' => $this->getTotal(),
        ];
    }

    /**
     * Returns a string representation of the DicePool
     *
     * @return string
     */
    public function __toString() : string
    {
        $droppedDice = array_udiff($this->originalDice, $this->dice, static function (DiceInterface $a, DiceInterface $b) {
            return strcmp(spl_object_hash($a), spl_object_hash($b));
        });

        $droppedDiceString = array_reduce($droppedDice, static function (string $output, DiceInterface $dice) {
            $value = preg_replace('/(.)/', "$1\u{0336}", (string)$dice->value());
            return sprintf('%s [%s]', $output, $value);
        }, '');

        return sprintf('[%s%s = %s]', implode(' ', $this->dice), $droppedDiceString, $this->getTotal());
    }
}
