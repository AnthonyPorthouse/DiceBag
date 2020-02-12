<?php
namespace DiceBag;

use DiceBag\Dice\DiceFactory;
use DiceBag\Dice\DiceInterface;
use DiceBag\Randomization\RandomizationEngine;
use PHPUnit\Framework\TestCase;

class DicePoolTest extends TestCase
{
    /**
     * @var \Prophecy\Prophecy\ObjectProphecy|RandomizationEngine
     */
    private $engine;

    public function setUp(): void
    {
        $this->engine = $this->prophesize(RandomizationEngine::class);
    }

    public function testNewDicePool()
    {
        $this->engine->getValue(1, 6)->willReturn(1, 2, 3, 4);

        $factory = new DiceFactory($this->engine->reveal());

        $dicePool = new DicePool($factory, '4d6');

        $this->assertInstanceOf(DicePool::class, $dicePool);
    }

    public function testGetDice()
    {
        $this->engine->getValue(1, 6)->willReturn(1, 2, 3, 4);

        $factory = new DiceFactory($this->engine->reveal());

        $dicePool = new DicePool($factory, '4d6');

        $this->assertCount(4, $dicePool->getDice());
        $this->assertContainsOnlyInstancesOf(DiceInterface::class, $dicePool->getDice());
    }

    public function testGetDroppedDice()
    {
        $this->engine->getValue(1, 6)->willReturn(1, 2, 3, 4);

        $factory = new DiceFactory($this->engine->reveal());

        $dicePool = new DicePool($factory, '4d6dl1');

        $this->assertCount(1, $dicePool->getDroppedDice());
        $this->assertContainsOnlyInstancesOf(DiceInterface::class, $dicePool->getDice());
    }

    public function testGetTotal()
    {
        $this->engine->getValue(1, 6)->willReturn(1, 2, 3, 4);

        $factory = new DiceFactory($this->engine->reveal());

        $dicePool = new DicePool($factory, '4d6');

        $this->assertEquals(10, $dicePool->getTotal());
    }

    public function testJsonSerialize()
    {
        $this->engine->getValue(1, 6)->willReturn(1, 2, 3, 4);

        $factory = new DiceFactory($this->engine->reveal());

        $dicePool = new DicePool($factory, '4d6dl1');

        $jsonSerialize = $dicePool->jsonSerialize();

        $this->assertArrayHasKey('appliedModifiers', $jsonSerialize);
        $this->assertArrayHasKey('dice', $jsonSerialize);
        $this->assertArrayHasKey('dropped', $jsonSerialize);
        $this->assertArrayHasKey('total', $jsonSerialize);
    }

    public function testToString()
    {
        $this->engine->getValue(1, 20)->willReturn(10, 12, 14, 20);

        $factory = new DiceFactory($this->engine->reveal());

        $dicePool = (string) new DicePool($factory, '4d20dl1');

        $this->assertEquals("[[12] [14] [20] [1\u{0336}0\u{0336}] = 46]", $dicePool);
    }
}
