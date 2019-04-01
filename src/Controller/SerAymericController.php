<?php

namespace App\Controller;

use App\Service\MogNet\Messages\Author;
use App\Service\MogNet\Messages\Embed;
use App\Service\MogNet\Messages\Image;
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
     * Send a content message
     *
     * @Route("/aymeric/say")
     */
    public function message(Request $request)
    {
        $content = json_decode($request->getContent());
        $message = trim($content->message);
        $userId  = trim($content->user_id);

        if (empty($message) || empty($userId)) {
            return $this->json([ false, 'Invalid submit data.' ]);
        }
    
        $message = new Text($message);
        
        $this->serAymeric->sendMessage($userId, $message->content);
        
        return $this->json([ true, 'Message sent ']);
    }

    /**
     * Send an embed message
     *
     * @Route("/aymeric/embed")
     */
    public function embed(Request $request)
    {
        $content = json_decode($request->getContent());
        $embed   = $content->embed;
        $userId  = $content->user_id;

        if (empty($message) || empty($userId)) {
            return $this->json([ false, 'Invalid submit data.' ]);
        }

        if (isset($embed->thumbnail)) {
            $embed->thumbnail = new Image($embed->thumbnail);
        }

        if (isset($embed->image)) {
            $embed->image = new Image($embed->image);
        }

        if (isset($embed->author)) {
            $embed->author = new Author($embed->author);
        }

        $embed = new Embed(
            $embed->title,
            $embed->hexColour,
            $embed->description,
            $embed->fields ?? null,
            $embed->footer ?? null,
            $embed->thumbnail ?? null,
            $embed->image ?? null,
            $embed->url ?? null,
            $embed->author ?? null
        );

        $this->serAymeric->sendEmbed($userId, $embed->getRestEmbed());

        return $this->json([ true, 'Message sent ']);
    }
}
