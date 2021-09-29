<?php

namespace App\Command;

use App\Parser\HTTPParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use App\Parser\HTTPRequestRepository;

class GetFileCommand extends Command
{
    /** @var string Simple command description */
    protected static string $defaultDescription = "Get filename from CLI";
    /** @var string Command name */
    protected static string $defaultName = "parser";

    /** @var string Local requirements for file name */
    private string $requireFilename;

    /**
     * Command configuration
     */
    protected function configure(): void
    {
        $this
            ->addArgument("filename", InputArgument::REQUIRED, "Input file name");
    }

    /**
     * @param InputInterface $input                     Interface to input
     * @param OutputInterface $output                   Interface to output
     * @return int                                      Result of open
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $parser = new HTTPParser(new HTTPRequestRepository());
        $parser->parse("file.txt");
        dump($parser->getJson());

        return Command::SUCCESS;
    }
}