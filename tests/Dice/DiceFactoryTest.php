<?php
namespace Dice;

use DiceBag\Dice\Dice;
use DiceBag\Dice\DiceFactory;
use DiceBag\Dice\DiceInterface;
use DiceBag\Dice\FudgeDice;
use DiceBag\Dice\Modifier;
use DiceBag\Randomization\MersenneTwister;
use PHPUnit\Framework\TestCase;

class DiceFactoryTest extends TestCase
{
    /** @var DiceFactory $factory */
    private $factory;

    public function setUp()
    {
        $this->factory = new DiceFactory(new MersenneTwister());
    }

    /**
     * @dataProvider diceProvider
     *
     * @param string $format The dice string to test
     * @param int $amount The amount of dice that should be created
     */
    public function testShouldReturnArrayOfDice($format, $amount)
    {
        $dice = $this->factory->makeDice($format);
        $this->assertContainsOnlyInstancesOf(DiceInterface::class, $dice);
        $this->assertCount($amount, $dice);
    }

    public function diceProvider()
    {
        return [
            'd6' => ['d6', 1],
            '2d6' => ['2d6', 2],
            'f' => ['f', 1],
            '2f' => ['2f', 2],
            '2' => ['2', 1],
            'empty string' => ['', 0],
        ];
    }
}
