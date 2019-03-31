<?php

namespace App\Command;

use App\Service\Greeting;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AppSayHelloCommand extends Command
{
    protected static $defaultName = 'app.say-hello';
    /**
     * @var Greeting
     */
    private $greeting;


    public function __construct(Greeting $greeting)
    {
        parent::__construct();
        $this->greeting = $greeting;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
            $io->writeln( $this->greeting->greet($arg1));
        }

//        if ($input->getOption($arg1)) {
//        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
    }
}
