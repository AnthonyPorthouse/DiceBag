<?php

use DiceBag\Dice\Dice;
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
        $randomizationDummy = $this->prophet->prophesize(\DiceBag\Randomization\Randomization::class);
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
}
