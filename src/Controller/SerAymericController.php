<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class SerAymericController extends AbstractController
{
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



    }
}
