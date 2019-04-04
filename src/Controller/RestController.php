<?php

namespace App\Controller;

use App\Service\Directory\Channels;
use App\Service\MogRest\MogRest;
use App\Service\SerAymeric\SerAymeric;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RestController extends AbstractController
{
    /** @var MogRest */
    private $mog;
    /** @var SerAymeric */
    private $serAymeric;
    
    public function __construct(MogRest $mog, SerAymeric $serAymeric)
    {
        $this->mog = $mog;
        $this->serAymeric = $serAymeric;
    }

    /**
     * Send a message to a channel
     *
     * @Route("/mog/notify")
     */
    public function mog(Request $request)
    {
        $json = json_decode($request->getContent());

        $channel = $json->channel ?? null;
        $content = $json->content ?? null;
        $embed   = $json->embed   ?? null;

        $channel = $channel ?: Channels::ADMIN_MOG;

        $this->mog->sendMessage($channel, $content, $embed);

        return $this->json([ true, 'Message sent ']);
    }

    /**
     * Send a message to a specific user
     *
     * @Route("/aymeric/notify")
     */
    public function aymeric(Request $request)
    {
        $json = json_decode($request->getContent());

        $userId  = $json->user_id ?? null;
        $content = $json->content ?? null;
        $embed   = $json->embed   ?? null;

        $this->serAymeric->sendMessage($userId, $content, $embed);

        return $this->json([ true, 'Message sent ']);
    }
}
