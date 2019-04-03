<?php

namespace App\Controller;

use App\Service\SerAymeric\SerAymeric;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SerAymericController extends AbstractController
{
    /** @var SerAymeric */
    private $serAymeric;
    
    public function __construct(SerAymeric $serAymeric)
    {
        $this->serAymeric = $serAymeric;
    }
    
    /**
     * Send a content message
     *
     * @Route("/aymeric/say")
     */
    public function message(Request $request)
    {
        $content = json_decode($request->getContent(), true);
        $message = trim($content['message'] ?? null);
        $userId  = trim($content['user_id'] ?? null);

        if (empty($message) || empty($userId)) {
            return $this->json([ false, 'Invalid submit data.' ]);
        }
        
        $this->serAymeric->sendMessage($userId, $message);
        return $this->json([ true, 'Message sent ']);
    }

    /**
     * Send an embed message
     *
     * @Route("/aymeric/embed")
     */
    public function embed(Request $request)
    {
        $content = json_decode($request->getContent(), true);
        $embed   = $content['embed'] ?? null;
        $userId  = $content['user_id'] ?? null;

        if (empty($embed) || empty($userId)) {
            return $this->json([ false, 'Invalid submit data.' ]);
        }

        // send embed json as is
        $this->serAymeric->sendEmbed($userId, $embed);
        return $this->json([ true, 'Message sent ']);
    }
}
