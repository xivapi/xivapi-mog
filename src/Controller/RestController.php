<?php

namespace App\Controller;

use App\Service\Directory\Channels;
use App\Service\MogRest\MogRest;
use App\Service\SerAymeric\SerAymeric;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RestController extends AbstractController
{
    /** @var MogRest */
    private $mog;
    /** @var SerAymeric */
    private $serAymeric;
    
    public function __construct(MogRest $mog, SerAymeric $serAymeric)
    {
        $this->mog = $mog;
        $this->serAymeric = $serAymeric;
    }

    /**
     * Send a message to a channel
     *
     * @Route("/mog/notify")
     */
    public function notifyViaMog(Request $request)
    {
        $json = json_decode($request->getContent());

        $channel = $json->channel ?? null;
        $content = $json->content ?? null;
        $embed   = $json->embed   ?? null;

        $channel = $channel ?: Channels::ADMIN_MOG;

        $this->mog->sendMessage($channel, $content, $embed);

        return $this->json([ true, 'Message sent ']);
    }

    /**
     * Send a message to a specific user
     *
     * @Route("/aymeric/notify")
     */
    public function notifyViaAymeric(Request $request)
    {
        $json = json_decode($request->getContent());

        $userId  = $json->user_id ?? null;
        $content = $json->content ?? null;
        $embed   = $json->embed   ?? null;

        $this->serAymeric->sendMessage($userId, $content, $embed);

        return $this->json([ true, 'Message sent ']);
    }

    /**
     * @Route("/users/patreon-tier")
     */
    public function userPatreonTier(Request $request)
    {
        $userId = $request->get('user_id') ?: null;

        if ($userId) {
            throw new \Exception("No user id provided. Provide one, dip shit.");
        }

        $userRoles = $this->mog->getRolesForUser((int)$userId);

        foreach (Channels::ROLE_PATREON_TIERS as $role => $tier) {
            if (in_array($role, $userRoles)) {
                return $this->json($tier);
            }
        }

        return $this->json(false);
    }
}
