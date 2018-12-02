<?php

namespace App\Controller;

use App\Service\MogNet\Messages\Text;
use App\Service\MogNet\MogRest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MessageController extends AbstractController
{
    const CHANNEL_ID = 477631558317244427;
    
    /** @var MogRest */
    private $bot;
    
    public function __construct(MogRest $bot)
    {
        $this->bot = $bot;
    }
    
    /**
     * @Route("/")
     */
    public function home()
    {
        return $this->json('Mog, XIVAPI/.com Discord Bot');
    }
    
    /**
     * @Route("/say")
     */
    public function post(Request $request)
    {
        // grab feedback json
        $message = new Text(trim($request->get('message')));
    
        // post it to the chat
        $this->bot->message(getenv('BOT_CHANNEL'), $message);
        return $this->json(true);
    }
}
