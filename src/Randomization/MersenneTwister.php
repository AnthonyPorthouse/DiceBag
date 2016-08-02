<?php
namespace DiceBag\Randomization;

class MersenneTwister implements RandomizationEngine
{
    /** {@inheritdoc} */
    public function getValue(int $min, int $max) : int
    {
        return mt_rand($min, $max);
    }
}
