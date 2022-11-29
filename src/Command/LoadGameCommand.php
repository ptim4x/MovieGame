<?php

declare(strict_types=1);

/*
 * This file is part of MovieGame test skills project.
 *
 * (c) Maxime Brignon <ptimax@lilo.org>
 */

namespace App\Command;

use App\MovieGame\Setup\Application\Command\NewGameSetCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

/**
 * Symfony console custom command.
 *
 * To execute :
 *
 * php bin/console app:data:load
 */
#[AsCommand(
    name: 'app:data:load',
    description: 'Movie game setup : load Question/Answer set',
)]
class LoadGameCommand extends Command
{
    public function __construct(
        private MessageBusInterface $messageBus,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            // the command help shown when running the command with the "--help" option
            ->setHelp('This command allows you to load game data from api call')
            ->addOption('moviedb', mode: InputOption::VALUE_NONE)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($input->getOption('moviedb')) {
            $command = new NewGameSetCommand(setSize: 100);

            $this->messageBus->dispatch($command);

            return Command::SUCCESS;
        }

        return Command::INVALID;
    }
}
