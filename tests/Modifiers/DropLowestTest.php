<?php
namespace DiceBag\Modifiers;

use DiceBag\Dice\DiceInterface;
use DiceBag\Dice\Modifier as DiceModifier;
use DiceBag\Randomization\RandomizationEngine;
use PHPUnit\Framework\TestCase;

class DropLowestTest extends TestCase
{
    /**
     * @dataProvider modifierProvider
     *
     * @param string $format
     * @param bool $validity
     */
    public function testIsValid(string $format, bool $validity)
    {
        $this->assertEquals($validity, DropLowest::isValid($format));
    }

    public function testApply()
    {
        $prophet = $this->prophesize(RandomizationEngine::class);
        $randomizer = $prophet->reveal();

        $modifier = new DropLowest('4d6dl1');
        $dice = [
            new DiceModifier($randomizer, 1),
            new DiceModifier($randomizer, 2),
            new DiceModifier($randomizer, 3),
            new DiceModifier($randomizer, 4),
        ];

        /** @var DiceInterface[] $remainingDice */
        $remainingDice = $modifier->apply($dice);

        $this->assertCount(3, $remainingDice);

        foreach ($remainingDice as $dice) {
            $this->assertNotEquals(1, $dice->value());
        }
    }

    public function modifierProvider()
    {
        return [
            '4d6dh1' => ['4d6dh1', false],
            '4d6dl1' => ['4d6dl1', true],
            '4d6kh1' => ['4d6kh1', false],
            '4d6kl1' => ['4d6kl1', false],
        ];
    }
}
