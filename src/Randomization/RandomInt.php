<?php

declare(strict_types=1);

namespace DiceBag\Randomization;

class RandomInt implements RandomizationEngine
{
    /** {@inheritdoc} */
    public function getValue(int $min, int $max) : int
    {
        try {
            return random_int($min, $max);
        } catch (\Exception $e) {
            throw new RandomizationEngineException(
                sprintf('Unable to get random value: %s', $e->getMessage()),
                0,
                $e
            );
        }
    }
}
