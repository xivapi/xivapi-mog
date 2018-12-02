<?php

namespace App\Command;

use App\Service\MogNet\MogNet;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RunCommand extends Command
{
    /** @var MogNet */
    private $mogNet;

    public function __construct(MogNet $mogNet)
    {
        $this->mogNet = $mogNet;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('RunCommand')
            ->setDescription('Run Da Bot!');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Mog Discord Bot</info>');
        $this->mogNet->run();
    }
}
