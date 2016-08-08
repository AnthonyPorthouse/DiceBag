<?php
namespace DiceBag;

use DiceBag\Dice\DiceFactory;
use DiceBag\Dice\DiceInterface;
use DiceBag\Randomization\RandomizationEngine;
use PHPUnit\Framework\TestCase;

class DicePoolTest extends TestCase
{

    public function testNewDicePool()
    {
        $prophet = $this->prophesize(RandomizationEngine::class);
        $prophet->getValue(1, 6)->willReturn(1, 2, 3, 4);
        $ranomizationEngine = $prophet->reveal();

        $factory = new DiceFactory($ranomizationEngine);

        $dicePool = new DicePool($factory, '4d6');

        $this->assertInstanceOf(DicePool::class, $dicePool);
    }

    public function testGetDice()
    {
        $prophet = $this->prophesize(RandomizationEngine::class);
        $prophet->getValue(1, 6)->willReturn(1, 2, 3, 4);
        $ranomizationEngine = $prophet->reveal();

        $factory = new DiceFactory($ranomizationEngine);

        $dicePool = new DicePool($factory, '4d6');

        $this->assertCount(4, $dicePool->getDice());
        $this->assertContainsOnlyInstancesOf(DiceInterface::class, $dicePool->getDice());
    }

    public function testGetDroppedDice()
    {
        $prophet = $this->prophesize(RandomizationEngine::class);
        $prophet->getValue(1, 6)->willReturn(1, 2, 3, 4);
        $ranomizationEngine = $prophet->reveal();

        $factory = new DiceFactory($ranomizationEngine);

        $dicePool = new DicePool($factory, '4d6dl1');

        $this->assertCount(1, $dicePool->getDroppedDice());
        $this->assertContainsOnlyInstancesOf(DiceInterface::class, $dicePool->getDice());
    }

    public function testGetTotal()
    {
        $prophet = $this->prophesize(RandomizationEngine::class);
        $prophet->getValue(1, 6)->willReturn(1, 2, 3, 4);
        $ranomizationEngine = $prophet->reveal();

        $factory = new DiceFactory($ranomizationEngine);

        $dicePool = new DicePool($factory, '4d6');

        $this->assertEquals(10, $dicePool->getTotal());
    }

    public function testJsonSerialize()
    {
        $prophet = $this->prophesize(RandomizationEngine::class);
        $prophet->getValue(1, 6)->willReturn(1, 2, 3, 4);
        $ranomizationEngine = $prophet->reveal();

        $factory = new DiceFactory($ranomizationEngine);

        $dicePool = new DicePool($factory, '4d6dl1');

        $jsonSerialize = $dicePool->jsonSerialize();

        $this->assertArrayHasKey('dice', $jsonSerialize);
        $this->assertArrayHasKey('dropped', $jsonSerialize);
        $this->assertArrayHasKey('total', $jsonSerialize);
    }

    public function testToString()
    {
        $prophet = $this->prophesize(RandomizationEngine::class);
        $prophet->getValue(1, 6)->willReturn(1, 2, 3, 4);
        $ranomizationEngine = $prophet->reveal();

        $factory = new DiceFactory($ranomizationEngine);

        $dicePool = (string) new DicePool($factory, '4d6dl1');

        $this->assertEquals("[[2] [3] [4] [1\u{0336}] (9)]", $dicePool);
    }
}
