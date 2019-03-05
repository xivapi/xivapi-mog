<?php

namespace App\Command;

use App\Service\SerAymeric\SerAymeric;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SerAymericCommand extends Command
{
    /** @var SerAymeric */
    private $serAymeric;

    public function __construct(SerAymeric $serAymeric)
    {
        $this->serAymeric = $serAymeric;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setName('SerAymericCommand')->setDescription('Test Ser Aymeric');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('<info>Ser Aymeric Test</info>');

        $this->serAymeric->sendMessage('42667995159330816', 'heyooo');
    }
}
