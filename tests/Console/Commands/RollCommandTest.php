<?php
namespace DiceBag\Console\Commands;

use PHPUnit\Framework\TestCase;
use DiceBag\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class RollCommandTest extends TestCase
{
    public function testExecute()
    {
        $application = new Application();

        $command = $application->find('roll');

        $commandTester = new CommandTester($command);

        $commandTester->execute([
            'command' => $command->getName(),
            'dice' => '2d6+10'
        ]);

        $output = $commandTester->getDisplay();
        $this->assertRegexp('/^(\[(?:\[?\d+\]?\s?)+\w?\(\d+\)\](?:\s|\+)*)+(= \d+)$/', $output);
    }
}
