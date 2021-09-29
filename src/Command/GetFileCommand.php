<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\FileHelper\File;

class GetFileCommand extends Command
{
    /** @var string Simple command description */
    protected static string $defaultDescription = "Get filename from CLI";
    /** @var string Command name */
    protected static string $defaultName = "parser";

    /** @var string Local requirements for file name */
    private string $requireFilename;

    protected function configure(): void
    {
        $this
            ->addArgument("filename", InputArgument::REQUIRED, "Input file name");
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'Log Parser',
            '==========',
            'Filename is: ' . $input->getArgument("filename"),
            '',
        ]);

        $inputtedFile = File::openFile($input->getArgument("filename"), "r+");

        $output->write('The command was executed successfully!');

        return Command::SUCCESS;
    }
}