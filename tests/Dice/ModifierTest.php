<?php
namespace DiceBag\Dice;

use DiceBag\Randomization\RandomizationEngine;
use PHPUnit\Framework\TestCase;

class ModifierTest extends TestCase
{
    public function testGetModifierValue()
    {
        $randomizationDummy = $this->prophesize(RandomizationEngine::class);
        $randomized = $randomizationDummy->reveal();

        $randomizationDummy->getValue()->shouldNotBeCalled();
        $dice = new Modifier($randomized, 6);
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
        $this->assertEquals($valid, Modifier::isValid($diceString));
    }

    public function diceFormatProvider()
    {
        return [
            ['d6', false],
            ['2d6', false],
            ['f', false],
            ['2f', false],
            ['1', true],
            ['', false],
        ];
    }

    public function testToString()
    {
        $randomizationDummy = $this->prophesize(RandomizationEngine::class);
        $randomized = $randomizationDummy->reveal();

        // Min Value
        $randomizationDummy->getValue()->shouldNotBeCalled();
        $dice = new Modifier($randomized, '1');
        $this->assertEquals('1', $dice->__toString());
    }
}
