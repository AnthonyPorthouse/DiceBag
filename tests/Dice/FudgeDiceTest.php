<?php
namespace Dice;

use DiceBag\Dice\FudgeDice;
use DiceBag\Randomization\RandomizationEngine;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophet;

class FudgeDiceTest extends TestCase
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
        $prophecy = $this->prophet->prophesize(RandomizationEngine::class);
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
            ['f', true],
            ['2f', true],
            ['1', false],
            ['', false],
        ];
    }

    public function testToString()
    {
        $prophecy = $this->prophet->prophesize(RandomizationEngine::class);
        $randomizationEngine = $prophecy->reveal();

        // Min Value
        $prophecy->getValue(-1, 1)->willReturn(1);
        $dice = new FudgeDice($randomizationEngine);
        $this->assertEquals('[1]', $dice->__toString());
    }
}
