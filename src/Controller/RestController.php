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
    public function say(Request $request)
    {
        $content = json_decode($request->getContent(), true);
        $channel = $content['channel'] ?? null;
        $content = $content['content'] ?? null;
        $embed   = $content['embed']   ?? null;

        $channel = $channel ?: Channels::ADMIN_MOG;

        $this->mog->sendMessage($channel, $content, $embed);

        return $this->json([ true, 'Message sent ']);
    }

    /**
     * Send a message to a specific user
     *
     * @Route("/aymeric/notify")
     */
    public function message(Request $request)
    {
        $content = json_decode($request->getContent(), true);
        $userId  = $content['user_id'] ?? null;
        $content = $content['content'] ?? null;
        $embed   = $content['embed']   ?? null;

        $this->serAymeric->sendMessage($userId, $content, $embed);

        return $this->json([ true, 'Message sent ']);
    }
}
