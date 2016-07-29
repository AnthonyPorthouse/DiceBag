<?php
namespace DiceBag\Console\Commands;

use DiceBag\DiceBag;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RollCommand extends Command
{
    protected function configure()
    {
        $this->setName('roll')
            ->setDescription('Rolls a Dice')
            ->addArgument(
                'dice',
                InputArgument::REQUIRED,
                'The Dice format in D20 notation'
            );
    }

    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $diceBag = DiceBag::factory($input->getArgument('dice'));

        $output->writeln($diceBag->__toString());

        return 0;
    }
}
