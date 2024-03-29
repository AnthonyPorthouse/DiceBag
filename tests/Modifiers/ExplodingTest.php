<?php

namespace DiceBag\Modifiers;

use DiceBag\Dice\DiceFactory;
use DiceBag\Dice\DiceInterface;
use DiceBag\Dice\Dice;
use DiceBag\Randomization\RandomizationEngine;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class ExplodingTest extends TestCase
{
    use ProphecyTrait;
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

    public function testExplodes()
    {
        $prophet = $this->prophesize(RandomizationEngine::class);
        $prophet->getValue(1, 6)->willReturn(6, 1);
        $randomizer = $prophet->reveal();
        $diceFactory = new DiceFactory($randomizer);

        $modifier = new Exploding('d6!');
        $dice = $diceFactory->makeDice('d6!');

        $dicePool = $modifier->apply($dice, $diceFactory);
        $this->assertCount(2, $dicePool);
    }

    public function testExplodesOnSpecificValue()
    {
        $prophet = $this->prophesize(RandomizationEngine::class);
        $prophet->getValue(1, 6)->willReturn(5, 6, 1);
        $randomizer = $prophet->reveal();
        $diceFactory = new DiceFactory($randomizer);

        $modifier = new Exploding('2d6!5');
        $dice = $diceFactory->makeDice('2d6!5');

        $dicePool = $modifier->apply($dice, $diceFactory);
        $this->assertCount(3, $dicePool);
    }

    public function testExplodesOnValuesGreaterThan()
    {
        $prophet = $this->prophesize(RandomizationEngine::class);
        $prophet->getValue(1, 6)->willReturn(5, 6, 1, 1);
        $randomizer = $prophet->reveal();
        $diceFactory = new DiceFactory($randomizer);

        $modifier = new Exploding('2d6!>5');
        $dice = $diceFactory->makeDice('2d6!>5');

        /** @var DiceInterface[] $remainingDice */
        $dicePool = $modifier->apply($dice, $diceFactory);

        $this->assertCount(4, $dicePool);
    }

    public function testExplodesOnValuesLessThan()
    {
        $prophet = $this->prophesize(RandomizationEngine::class);
        $prophet->getValue(1, 6)->willReturn(1, 2, 6, 6);
        $randomizer = $prophet->reveal();
        $diceFactory = new DiceFactory($randomizer);

        $modifier = new Exploding('2d6!<2');
        $dice = $diceFactory->makeDice('2d6!<2');

        /** @var DiceInterface[] $remainingDice */
        $dicePool = $modifier->apply($dice, $diceFactory);

        $this->assertCount(4, $dicePool);
    }

    /**
     * @dataProvider explodingStringProvider
     *
     * @param string $format Input Dice Format
     * @param string $output Expected String Output
     * @param int[] $randomValues Random Response values
     */
    public function testToString(string $format, string $output, array $randomValues)
    {
        $prophet = $this->prophesize(RandomizationEngine::class);
        $prophet->getValue(1, 10)->willReturn(...$randomValues);
        $randomizer = $prophet->reveal();
        $factory = new DiceFactory($randomizer);

        $modifier = new Exploding($format);
        $dice = $factory->makeDice($format);

        /** @var DiceInterface[] $remainingDice */
        $modifier->apply($dice, $factory);

        $this->assertEquals($output, $modifier->__toString());
    }

    /**
     * @dataProvider explodingStringProvider
     *
     * @param string $format Input Dice Format
     * @param string $output Expected String Output
     * @param int[] $randomValues Random Response Values
     */
    public function testJsonSerialize(string $format, string $output, array $randomValues)
    {
        $prophet = $this->prophesize(RandomizationEngine::class);
        $prophet->getValue(1, 10)->willReturn(...$randomValues);
        $randomizer = $prophet->reveal();
        $factory = new DiceFactory($randomizer);

        $modifier = new Exploding($format);
        $dice = $factory->makeDice($format);

        /** @var DiceInterface[] $remainingDice */
        $modifier->apply($dice, $factory);

        $this->assertEquals($output, $modifier->__toString());
    }

    public function explodingStringProvider()
    {
        return [
            '4d10!' => ['4d10!', 'Dice explode when result is = 10', [1]],
            '4d10!9' => ['4d10!9', 'Dice explode when result is = 9', [1]],
            '4d10!>8' => ['4d10!>8', 'Dice explode when result is >= 8', [1]],
            '4d10!<2' => ['4d10!<2', 'Dice explode when result is <= 2', [10]],
        ];
    }

    public function modifierProvider()
    {
        return [
            '4d6!' => ['4d6!', true],
            '4d6!' => ['4d6!5', true],
            '4d6!' => ['4d6!>5', true],
            '4d6!' => ['4d6!<1', true],
            '4d6dh1' => ['4d6dh1', false],
            '4d6dl1' => ['4d6dl1', false],
            '4d6kh1' => ['4d6kh1', false],
            '4d6kl1' => ['4d6kl1', false],
        ];
    }
}
