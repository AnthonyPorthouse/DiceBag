<?php
namespace DiceBag;

use DiceBag\Randomization\RandomizationEngine;
use PHPUnit\Framework\TestCase;

class DiceBagTest extends TestCase
{
    public function testFactory()
    {
        $diceBag = DiceBag::factory('2d6+10');
        $this->assertInstanceOf(DiceBag::class, $diceBag);
    }

    public function testNewDiceBag()
    {
        $diceBag = new DiceBag(['4d6']);

        $this->assertInstanceOf(DiceBag::class, $diceBag);
    }

    public function testGetDicePools()
    {
        $diceBag = DiceBag::factory('2d6+10');

        $this->assertContainsOnlyInstancesOf(DicePool::class, $diceBag->getDicePools());
        $this->assertCount(2, $diceBag->getDicePools());
    }

    public function testGetTotal()
    {
        $prophet = $this->prophesize(RandomizationEngine::class);
        $prophet->getValue(1, 6)->willReturn(6);
        $randomization = $prophet->reveal();

        $diceBag = DiceBag::factory('2d6+10', $randomization);

        $this->assertEquals(22, $diceBag->getTotal());
    }

    public function testJsonSerialize()
    {
        $diceBag = DiceBag::factory('2d6+10');

        $serialized = $diceBag->jsonSerialize();

        $this->assertArrayHasKey('pools', $serialized);
        $this->assertArrayHasKey('total', $serialized);

        $this->assertContainsOnlyInstancesOf(DicePool::class, $serialized['pools']);
    }

    public function testToString()
    {
        $prophet = $this->prophesize(RandomizationEngine::class);
        $prophet->getValue(1, 6)->willReturn(6);
        $randomization = $prophet->reveal();

        $diceBag = DiceBag::factory('2d6+10', $randomization);

        $this->assertEquals('[[6] [6] (12)] + [10 (10)] = 22', (string) $diceBag);
    }

    public function testCaseInsensitivity()
    {
        $diceBag = DiceBag::factory('4dF');
        $this->assertCount(1, $diceBag->getDicePools());
        $this->assertCount(4, $diceBag->getDicePools()[0]->getDice());

        $diceBag = DiceBag::factory('4df');
        $this->assertCount(1, $diceBag->getDicePools());
        $this->assertCount(4, $diceBag->getDicePools()[0]->getDice());
    }
}
