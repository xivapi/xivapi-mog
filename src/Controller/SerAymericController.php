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
     * Send a message to a specific user
     *
     * @Route("/aymeric/say")
     */
    public function message(Request $request)
    {
        $content = json_decode($request->getContent(), true);
        $message = $content['message'] ?? null;
        $embed   = $content['embed']   ?? null;
        $userId  = $content['user_id'] ?? null;

        if ($embed) {
            $this->serAymeric->sendEmbed($userId, $embed);
        } else {
            $this->serAymeric->sendMessage($userId, $message);
        }

        return $this->json([ true, 'Message sent ']);
    }
}
