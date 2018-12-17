<?php

namespace App\Controller;

use App\Service\MogNet\MogRest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RoleController extends AbstractController
{
    const CHANNEL_ID = 477631558317244427;
    
    /** @var MogRest */
    private $mog;
    
    public function __construct(MogRest $mog)
    {
        $this->mog = $mog;
    }
    /**
     * @Route("/role/ArcaneDisgea")
     */
    public function post(Request $request)
    {
        $name = strip_tags(trim(substr($request->get('name'), 0, 64)));

        $this->mog->client()->guild->modifyGuildRole([
            'guild.id'    => 474518001173921794,
            'role.id'     => 516086224738451466,
            'name'        => $name,
            'mentionable' => true,
            'hoist'       => true,
        ]);

        $this->mog->client()->channel->createMessage([
            'channel.id'  => 474519195963490305,
            'content'     => '<@&516086224738451466> Your role was set by some randomer on the internet to: '. $name,
        ]);
    }
}
