<?php

namespace DiceBag\Modifiers;

use DiceBag\Dice\DiceFactory;
use DiceBag\Dice\DiceInterface;
use DiceBag\Dice\Modifier as DiceModifier;
use DiceBag\Randomization\RandomizationEngine;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class DropLowestTest extends TestCase
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
        $this->assertEquals($validity, DropLowest::isValid($format));
    }

    public function testApply()
    {
        $prophet = $this->prophesize(RandomizationEngine::class);
        $prophet->getValue(1, 6)->willReturn(1, 2, 3, 4);
        $randomizer = $prophet->reveal();
        $factory = new DiceFactory($randomizer);

        $modifier = new DropLowest('4d6dl1');
        $dice = $factory->makeDice('4d6dl1');

        /** @var DiceInterface[] $remainingDice */
        $remainingDice = $modifier->apply($dice, $factory);

        $this->assertCount(3, $remainingDice);

        foreach ($remainingDice as $dice) {
            $this->assertNotEquals(1, $dice->value());
        }
    }

    public function testToString()
    {
        $prophet = $this->prophesize(RandomizationEngine::class);
        $prophet->getValue(1, 6)->willReturn(1, 2, 3, 4);
        $randomizer = $prophet->reveal();
        $factory = new DiceFactory($randomizer);

        $modifier = new DropLowest('4d6dl1');
        $dice = $factory->makeDice('4d6dl1');

        /** @var DiceInterface[] $remainingDice */
        $remainingDice = $modifier->apply($dice, $factory);

        $this->assertEquals("Drop the Lowest 1 Dice", $modifier->__toString());
    }

    public function testJsonSerialize()
    {
        $prophet = $this->prophesize(RandomizationEngine::class);
        $prophet->getValue(1, 6)->willReturn(1, 2, 3, 4);
        $randomizer = $prophet->reveal();
        $factory = new DiceFactory($randomizer);

        $modifier = new DropLowest('4d6dl1');
        $dice = $factory->makeDice('4d6dl1');

        /** @var DiceInterface[] $remainingDice */
        $remainingDice = $modifier->apply($dice, $factory);

        $this->assertEquals("Drop the Lowest 1 Dice", $modifier->jsonSerialize());
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
