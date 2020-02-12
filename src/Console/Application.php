<?php

declare(strict_types=1);

namespace DiceBag\Console;

use DiceBag\Console\Commands\RollCommand;

class Application extends \Symfony\Component\Console\Application
{
    public const APPLICATION_NAME = 'DiceBag';
    public const APPLICATION_VERSION = '0.0.1';

    public function __construct()
    {
        parent::__construct(self::APPLICATION_NAME, self::APPLICATION_VERSION);

        $this->addCommands([
            new RollCommand(),
        ]);
    }
}
