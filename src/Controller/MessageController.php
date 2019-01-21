<?php

namespace App\Controller;

use App\Service\MogNet\Messages\Text;
use App\Service\MogNet\MogRest;
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
        $message = trim($request->get('message'));
        
        if (empty($message)) {
            return $this->json([
                false,
                'No message provided'
            ]);
        }
        
        // grab feedback json
        $message = new Text($message);
    
        // post it to the chat
        $this->mog->message(477631558317244427, $message);
        return $this->json([
            true,
            'Message sent successfully'
        ]);
    }
}
