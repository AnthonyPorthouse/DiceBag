<?php

declare(strict_types=1);

namespace DiceBag\Randomization;

interface RandomizationEngine
{
    /**
     * Returns an integer value between the two given values, inclusively
     *
     * @param int $min The lowest possible value
     * @param int $max The largest possible value
     *
     * @throws RandomizationEngineException When an error in the engine occurs
     *
     * @return int
     */
    public function getValue(int $min, int $max) : int;
}
