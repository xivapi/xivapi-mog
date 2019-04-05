<?php

namespace App\Command;

use App\Service\Directory\Channels;
use App\Service\MogRest\MogRest;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetRolesCommand extends Command
{
    /** @var MogRest */
    private $mog;

    public function __construct(MogRest $mog)
    {
        $this->mog = $mog;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('GetRolesCommand')
            ->setDescription('Get all the roles for all users in a channel')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $userRoles = $this->mog->getRolesForUser(42667995159330816);

        print_r($userRoles);

        $roleTiers = [
            Channels::ROLE_PATREON_DPS        => 4,
            Channels::ROLE_PATREON_HEALER     => 3,
            Channels::ROLE_PATREON_TANK       => 2,
            Channels::ROLE_PATREON_ADVENTURER => 1,
        ];

        $userTier = 0;
        foreach ($roleTiers as $role => $tier) {
            if (in_array($role, $userRoles)) {
                $userTier = $tier;
                break;
            }
        }

        print_r([
            "User tier = {$userTier}"
        ]);
    }
}
