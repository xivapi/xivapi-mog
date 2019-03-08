<?php

namespace App\Controller;

use App\Service\Api\Response;
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
     * @Route("/ser-aymeric/say")
     */
    public function post(Request $request)
    {
        $content = json_decode($request->getContent());

        $this->serAymeric->sendDirectMessage(42667995159330816, $content->message);

        return $this->json(
            (new Response(true, 'Message Sent'))->toArray()
        );
    }
}
