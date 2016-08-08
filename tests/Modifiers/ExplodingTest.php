<?php
namespace DiceBag\Modifiers;

use DiceBag\Dice\DiceFactory;
use DiceBag\Dice\DiceInterface;
use DiceBag\Dice\Dice;
use DiceBag\Randomization\RandomizationEngine;
use PHPUnit\Framework\TestCase;

class ExplodingTest extends TestCase
{
    /**
     * @dataProvider modifierProvider
     *
     * @param string $format
     * @param bool $validity
     */
    public function testIsValid(string $format, bool $validity)
    {
        $this->assertEquals($validity, Exploding::isValid($format));
    }

    public function testApply()
    {
        $prophet = $this->prophesize(RandomizationEngine::class);
        $prophet->getValue(1, 2)->willReturn(2, 1);
        $randomizer = $prophet->reveal();
        $diceFactory = new DiceFactory($randomizer);

        $modifier = new Exploding('1d2!');
        $dice = $diceFactory->makeDice('1d2!');

        /** @var DiceInterface[] $remainingDice */
        $dicePool = $modifier->apply($dice, $diceFactory);

        $this->assertCount(2, $dicePool);
    }

    public function modifierProvider()
    {
        return [
            '4d6!' => ['4d6!', true],
            '4d6dh1' => ['4d6dh1', false],
            '4d6dl1' => ['4d6dl1', false],
            '4d6kh1' => ['4d6kh1', false],
            '4d6kl1' => ['4d6kl1', false],
        ];
    }
}
