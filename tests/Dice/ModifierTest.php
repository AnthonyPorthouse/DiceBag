<?php
namespace Dice;

use DiceBag\Dice\Modifier;
use DiceBag\Randomization\RandomizationEngine;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophet;

class ModifierTest extends TestCase
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

    public function testGetModifierValue()
    {
        $randomizationDummy = $this->prophet->prophesize(RandomizationEngine::class);
        $randomized = $randomizationDummy->reveal();

        $randomizationDummy->getValue()->shouldNotBeCalled();
        $dice = new Modifier($randomized, 6);
        $this->assertEquals(6, $dice->value());
    }

    /**
     * @dataProvider diceFormatProvider
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
        $randomizationDummy = $this->prophet->prophesize(RandomizationEngine::class);
        $randomized = $randomizationDummy->reveal();

        // Min Value
        $randomizationDummy->getValue()->shouldNotBeCalled();
        $dice = new Modifier($randomized, '1');
        $this->assertEquals('1', $dice->__toString());
    }
}
