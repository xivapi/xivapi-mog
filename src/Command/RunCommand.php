<?php

namespace App\Command;

use App\Service\MogNet\MogNet;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RunCommand extends Command
{
    /** @var MogNet */
    private $mog;

    public function __construct(MogNet $mog)
    {
        $this->mog = $mog;
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
        $this->mog->run();
    }
}
