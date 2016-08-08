<?php
namespace DiceBag\Modifiers;

use DiceBag\Dice\DiceFactory;
use DiceBag\Dice\DiceInterface;
use DiceBag\Dice\Modifier as DiceModifier;
use DiceBag\Randomization\RandomizationEngine;
use PHPUnit\Framework\TestCase;

class KeepHighestTest extends TestCase
{
    /**
     * @dataProvider modifierProvider
     *
     * @param string $format
     * @param bool $validity
     */
    public function testIsValid(string $format, bool $validity)
    {
        $this->assertEquals($validity, KeepHighest::isValid($format));
    }

    public function testApply()
    {
        $prophet = $this->prophesize(RandomizationEngine::class);
        $prophet->getValue(1, 6)->willReturn(1, 2, 3, 4);
        $randomizer = $prophet->reveal();
        $factory = new DiceFactory($randomizer);

        $modifier = new KeepHighest('4d6kh1');
        $dice = $factory->makeDice('4d6kh1');

        /** @var DiceInterface[] $remainingDice */
        $remainingDice = $modifier->apply($dice, $factory);

        $this->assertCount(1, $remainingDice);

        foreach ($remainingDice as $dice) {
            $this->assertEquals(4, $dice->value());
        }
    }

    public function modifierProvider()
    {
        return [
            '4d6dh1' => ['4d6dh1', false],
            '4d6dl1' => ['4d6dl1', false],
            '4d6kh1' => ['4d6kh1', true],
            '4d6kl1' => ['4d6kl1', false],
        ];
    }
}
