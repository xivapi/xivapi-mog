<?php

namespace App\Controller;

use App\Service\MogRest\MogRest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
