<?php
namespace DiceBag\Randomization;

class RandomInt implements RandomizationEngine
{
    /** {@inheritdoc} */
    public function getValue(int $min, int $max) : int
    {
        return random_int($min, $max);
    }
}
