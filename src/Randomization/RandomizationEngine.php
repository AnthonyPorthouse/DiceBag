<?php
namespace DiceBag\Randomization;

interface RandomizationEngine
{
    /**
     * Returns an integer value between the two given values, inclusively
     *
     * @param int $min The lowest possible value
     * @param int $max The largest possible value
     *
     * @return int
     */
    public function getValue(int $min, int $max) : int;
}
