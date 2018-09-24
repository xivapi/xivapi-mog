<?php

namespace App\Controller;

use App\Service\MogNet\Messages\Text;
use App\Service\MogNet\MogRest;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MessageController extends Controller
{
    /** @var MogRest */
    private $bot;
    
    public function __construct(MogRest $bot)
    {
        $this->bot = $bot;
    }
    
    /**
     * @Route("/mog/message/post", methods="POST")
     */
    public function post(Request $request)
    {
        // grab feedback json
        $post = json_decode($request->getContent());
        $message = new Text($post->message);
    
        // post it to the chat
        $this->bot->message(getenv('BOT_CHANNEL'), $message);
        return $this->json(true);
    }
}
