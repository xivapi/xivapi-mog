<?php

namespace App\Command;

use App\Service\MogNet\MogNet;
use App\Service\MogNet\MogRest;
use RestCord\Model\Guild\Guild;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class RandomRole extends Command
{
    /** @var MogRest */
    private $mog;

    public function __construct(MogRest $mog)
    {
        parent::__construct();

        $this->mog = $mog;
    }

    protected function configure()
    {
        $this->setName('RandomRole');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->mog->client()->guild->modifyGuildRole([
            'guild.id'    => 474518001173921794,
            'role.id'     => 516086224738451466,
            'name'        => 'TheVeryBest',
            'mentionable' => true,
            'hoist'       => true,
        ]);

        $this->mog->client()->channel->createMessage([
            'channel.id'  => 474519195963490305,
            'content'     => '<@&516086224738451466> Hi',
        ]);
    }
}
