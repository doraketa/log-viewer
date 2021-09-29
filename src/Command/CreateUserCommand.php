<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetFileNameCommand extends Command
{
    protected static string $defaultDescription = "Get filename from CLI";
    protected static string $defaultName = "parser:parse";

    private bool $requireFilename;

    public function __construct(bool $requireFilename = false)
    {
        $this->requireFilename = $requireFilename;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument("filename", $this->requireFilename ? InputArgument::REQUIRED : InputArgument::OPTIONAL, 'File Name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'Log Parser',
            '==========',
            '',
        ]);

        return Command::SUCCESS;
    }
}