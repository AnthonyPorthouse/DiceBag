<?php
namespace DiceBag\Dice;

use DiceBag\Randomization\RandomizationEngine;
use PHPUnit\Framework\TestCase;

class FudgeDiceTest extends TestCase
{
    public function testGetDiceValue()
    {
        $prophecy = $this->prophesize(RandomizationEngine::class);
        $randomizationEngine = $prophecy->reveal();

        // Min Value
        $prophecy->getValue(-1, 1)->willReturn(-1);
        $dice = new FudgeDice($randomizationEngine);
        $this->assertEquals(-1, $dice->value());

        // Max Value
        $prophecy->getValue(-1, 1)->willReturn(1);
        $dice = new FudgeDice($randomizationEngine);
        $this->assertEquals(1, $dice->value());
    }

    /**
     * @dataProvider diceFormatProvider
     *
     * @param string $diceString
     * @param bool $valid
     */
    public function testIsValid(string $diceString, bool $valid)
    {
        $this->assertEquals($valid, FudgeDice::isValid($diceString));
    }

    public function diceFormatProvider()
    {
        return [
            ['d6', false],
            ['2d6', false],
            ['dF', true],
            ['2dF', true],
            ['1', false],
            ['', false],
        ];
    }

    public function testJson()
    {
        $randomizationDummy = $this->prophesize(RandomizationEngine::class);
        $randomizationDummy->getValue(-1, 1)->willReturn(1);
        $randomizationEngine = $randomizationDummy->reveal();

        $dice = new FudgeDice($randomizationEngine);

        $expected = json_encode([
            'min' => -1,
            'max' => 1,
            'result' => 1,
        ]);

        $this->assertJsonStringEqualsJsonString($expected, json_encode($dice));
    }

    public function testToString()
    {
        $prophecy = $this->prophesize(RandomizationEngine::class);
        $randomizationEngine = $prophecy->reveal();

        // Min Value
        $prophecy->getValue(-1, 1)->willReturn(1);
        $dice = new FudgeDice($randomizationEngine);
        $this->assertEquals('[1]', $dice->__toString());
    }
}
