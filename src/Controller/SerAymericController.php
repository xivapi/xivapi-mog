<?php

namespace App\Controller;

use App\Service\MogNet\Messages\Text;
use App\Service\SerAymeric\SerAymeric;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
        if ($request->get('key') != getenv('BOT_USAGE_KEY')) {
            throw new NotFoundHttpException();
        }

        $request = \GuzzleHttp\json_decode($request->getContent());

        if (!isset($request->message)) {
            throw new NotFoundHttpException();
        }

        $message = trim($request->message);
        $userId  = trim($request->user_id);

        if (empty($message)) {
            return $this->json([ false, 'No message provided' ]);
        }
    
        $message = new Text($message);
        
        $this->serAymeric->sendMessage($userId, $message->content);
        
        return $this->json([ true, 'Message sent ']);
    }
}
