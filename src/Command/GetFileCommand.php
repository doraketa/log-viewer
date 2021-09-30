<?php

namespace App\Command;

use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Command\Command;
use App\Exception\CreatePointerException;
use App\Parser\HTTPRequestRepository;
use App\Parser\HTTPParser;

class GetFileCommand extends Command
{
    /** @var string Simple command description */
    protected static string $defaultDescription = "Get filename from CLI";
    /** @var string Command name */
    protected static string $defaultName = "parser";

    /**
     * Command configuration
     */
    protected function configure(): void
    {
        $this->addArgument("filename", InputArgument::REQUIRED, "Input file name");
    }

    /**
     * @param InputInterface $input Interface to input
     * @param OutputInterface $output Interface to output
     * @return int                                      Result of open
     * @throws CreatePointerException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $parser = new HTTPParser(new HTTPRequestRepository());
        $parser->parse($input->getArgument("filename"));
        dump($parser->getJson());

        return Command::SUCCESS;
    }
}
