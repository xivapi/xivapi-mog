<?php

namespace App\Controller;

use App\Service\Directory\Rooms;
use App\Service\MogNet\Messages\Text;
use App\Service\MogNet\MogRest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
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
     * @Route("/")
     */
    public function home()
    {
        return $this->json('Mog, The XIVAPI.com Discord Bot');
    }
    
    /**
     * @Route("/say")
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

        if (empty($message)) {
            return $this->json([ false, 'No message provided' ]);
        }

        // grab feedback json
        $message = new Text($message);
        $room    = isset($request->room) ? Rooms::get($request->room) : Rooms::ADMIN_MOG;

        // post it to the chat
        $this->mog->message($room, $message);
        return $this->json([ true, 'Message sent successfully' ]);
    }
}
