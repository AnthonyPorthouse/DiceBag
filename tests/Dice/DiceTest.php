<?php
namespace Dice;

use DiceBag\Dice\Dice;
use DiceBag\Randomization\RandomizationEngine;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophet;

class DiceTest extends TestCase
{
    /** @var  Prophet */
    private $prophet;

    protected function setUp()
    {
        $this->prophet = new Prophet();
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }

    public function testGetDiceValue()
    {
        $randomizationDummy = $this->prophet->prophesize(RandomizationEngine::class);
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
     */
    public function testIsValid(string $diceString, bool $valid)
    {
        $this->assertEquals($valid, Dice::isValid($diceString));
    }

    public function testToString()
    {
        $randomizationDummy = $this->prophet->prophesize(RandomizationEngine::class);
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
