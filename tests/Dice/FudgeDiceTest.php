<?php
namespace Dice;

use DiceBag\Dice\FudgeDice;
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
        $randomizationDummy = $this->prophet->prophesize(\DiceBag\Randomization\Randomization::class);
        $randomized = $randomizationDummy->reveal();

        // Min Value
        $randomizationDummy->getValue(-1, 1)->willReturn(-1);
        $dice = new FudgeDice($randomized);
        $this->assertEquals(-1, $dice->value());

        // Max Value
        $randomizationDummy->getValue(-1, 1)->willReturn(1);
        $dice = new FudgeDice($randomized);
        $this->assertEquals(1, $dice->value());
    }
}
