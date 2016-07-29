<?php
namespace DiceBag\Dice;

class Dice implements DiceInterface
{
    /** @var int $value */
    private $value;

    /**
     * Dice constructor.
     *
     * @param int $size
     */
    public function __construct(int $size)
    {
        $this->value = (int) mt_rand(1, $size);
    }

    public function value() : int
    {
        return $this->value;
    }

    public function __toString()
    {
        return '[' . $this->value() . ']';
    }
}
