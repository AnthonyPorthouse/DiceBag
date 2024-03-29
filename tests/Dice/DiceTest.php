<?php

namespace DiceBag\Dice;

use DiceBag\Randomization\RandomizationEngine;
use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;

class DiceTest extends TestCase
{
    use ProphecyTrait;

    public function testGetDiceValue()
    {
        $randomizationDummy = $this->prophesize(RandomizationEngine::class);
        $randomized = $randomizationDummy->reveal();

        // Min Value
        $randomizationDummy->getValue(1, 6)->willReturn(1);
        $dice = new Dice($randomized, 6);
        $this->assertEquals(1, $dice->value());

        // Max Value
        $randomizationDummy->getValue(1, 6)->willReturn(6);
        $dice = new Dice($randomized, 6);
        $this->assertEquals(6, $dice->value());
    }

    /**
     * @dataProvider diceFormatProvider
     *
     * @param string $diceString
     * @param bool $valid
     */
    public function testIsValid(string $diceString, bool $valid)
    {
        $this->assertEquals($valid, Dice::isValid($diceString));
    }

    public function testJson()
    {
        $randomizationDummy = $this->prophesize(RandomizationEngine::class);
        $randomizationDummy->getValue(1, 6)->willReturn(1);
        $randomized = $randomizationDummy->reveal();

        $dice = new Dice($randomized, 6);

        $expected = json_encode([
            'min' => 1,
            'max' => 6,
            'result' => 1,
        ]);

        $this->assertJsonStringEqualsJsonString($expected, json_encode($dice));
    }

    public function testToString()
    {
        $randomizationDummy = $this->prophesize(RandomizationEngine::class);
        $randomized = $randomizationDummy->reveal();

        // Min Value
        $randomizationDummy->getValue(1, 6)->willReturn(1);
        $dice = new Dice($randomized, 6);
        $this->assertEquals('[1]', $dice->__toString());
    }

    public function diceFormatProvider()
    {
        return [
            ['d6', true],
            ['2d6', true],
            ['f', false],
            ['2f', false],
            ['1', false],
            ['', false],
        ];
    }
}
