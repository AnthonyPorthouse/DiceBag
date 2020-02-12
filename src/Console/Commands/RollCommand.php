<?php

declare(strict_types=1);

namespace DiceBag\Console\Commands;

use DiceBag\DiceBag;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RollCommand extends Command
{
    /** {@inheritdoc} */
    protected function configure(): void
    {
        $this->setName('roll')
            ->setDescription('Rolls a Dice')
            ->addArgument(
                'dice',
                InputArgument::REQUIRED,
                'The Dice format in D20 notation'
            );
    }

    /** {@inheritdoc} */
    protected function execute(InputInterface $input, OutputInterface $output) : int
    {
        $diceString = $input->getArgument('dice') ?? '';
        if (is_array($diceString)) {
            $diceString = implode(' ', $diceString);
        }

        $diceBag = DiceBag::factory($diceString);

        $output->writeln($diceBag->__toString());

        return 0;
    }
}
