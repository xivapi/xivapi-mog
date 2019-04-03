<?php

namespace App\Controller;

use App\Service\MogRest\MogRest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    /** @var MogRest */
    private $mog;
    
    public function __construct(MogRest $mog)
    {
        $this->mog = $mog;
    }

    /**
     * @Route("/mog/say")
     */
    public function say(Request $request)
    {
        $content = json_decode($request->getContent(), true);
        $message = trim($content['message'] ?? null);
        $channel = trim($content['channel'] ?? null);

        if (empty($message) || empty($userId)) {
            return $this->json([ false, 'Invalid submit data.' ]);
        }

        // post it to the chat
        $this->mog->sendMessage($channel, $message);

        return $this->json([ true, 'Message sent ']);
    }

    /**
     * @Route("/mog/embed")
     */
    public function embed(Request $request)
    {
        $content = json_decode($request->getContent(), true);
        $embed   = $content['embed'] ?? null;
        $channel = trim($content['channel'] ?? null);

        if (empty($embed) || empty($userId)) {
            return $this->json([ false, 'Invalid submit data.' ]);
        }

        // post it to the chat
        $this->mog->sendEmbed($channel, $embed);

        return $this->json([ true, 'Message sent ']);
    }
}
