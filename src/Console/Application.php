<?php
namespace DiceBag\Console;

use DiceBag\Console\Commands\RollCommand;

class Application extends \Symfony\Component\Console\Application
{
    const APPLICATION_NAME = 'DiceBag';
    const APPLICATION_VERSION = '0.0.1';

    public function __construct()
    {
        parent::__construct(self::APPLICATION_NAME, self::APPLICATION_VERSION);

        $this->addCommands([
            new RollCommand(),
        ]);

        $this->run();
    }
}
