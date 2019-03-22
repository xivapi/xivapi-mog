<?php

namespace App\Controller;

use App\Service\Api\Response;
use App\Service\MogNet\Messages\Text;
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
     * @Route("/say")
     */
    public function say(Request $request)
    {
        $content = json_decode($request->getContent());

        // grab the discord channel from the request
        $channel = $content->channel ?? null;

        if ($channel === null) {
            throw new \Exception('A channel must be provided in the request.');
        }

        // grab feedback json
        $message = new Text($content->message ?? false);

        // post it to the chat
        $this->mog->sendMessage($channel, $message);

        return $this->json(
            (new Response(true, 'Message Sent'))->toArray()
        );
    }
}
