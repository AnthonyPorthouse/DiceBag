<?php
namespace DiceBag\Dice;

class Modifier implements DiceInterface
{
    /** @var int $value */
    private $value;

    public function __construct(string $modifier)
    {
        $this->value = (int) $modifier;
    }

    /**
     * Returns the fixed modifiers value
     *
     * @return int
     */
    public function value() : int
    {
        return $this->value;
    }

    public function __toString() : string
    {
        return $this->value();
    }
}
