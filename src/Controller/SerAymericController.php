<?php

namespace App\Controller;

use App\Service\MogNet\Messages\Text;
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
     * @Route("/aymeric/say")
     */
    public function post(Request $request)
    {
        $content = json_decode($request->getContent());
        $message = trim($content->message);
        $userId  = trim($content->user_id);

        if (empty($message)) {
            return $this->json([ false, 'No message provided' ]);
        }
    
        $message = new Text($message);
        
        $this->serAymeric->sendDirectMessage($userId, $message->content);
        
        return $this->json([ true, 'Message sent ']);
    }
}
