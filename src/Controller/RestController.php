<?php

namespace App\Controller;

use App\Service\Directory\Channels;
use App\Service\MogRest\MogRest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RestController extends AbstractController
{
    /** @var MogRest */
    private $mog;
    
    public function __construct(MogRest $mog)
    {
        $this->mog = $mog;
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

        return $this->json(
            $this->mog->sendMessage($channel, $content, $embed)
        );
    }

    /**
     * Send a message to a channel
     *
     * @Route("/mog/dm")
     */
    public function dmViaMog(Request $request)
    {
        $json = json_decode($request->getContent());

        $user    = $json->user_id ?? null;
        $content = $json->content ?? null;
        $embed   = $json->embed   ?? null;

        return $this->json(
            $this->mog->sendDirectMessage($user, $content, $embed)
        );
    }

    /**
     * @Route("/users/patreon-tier")
     */
    public function userPatreonTier(Request $request)
    {
        /*
        $userId = $request->get('user_id') ?: null;

        if ($userId === null) {
            throw new \Exception("No user id provided. Provide one, dip shit.");
        }

        try {
            $userRoles = $this->mog->getRolesForUser((int)$userId);
        } catch (\Exception $ex) {
            return $this->json(
                new Response($ex->getCode(), 'Could not get role for user')
            );
        }

        foreach (Channels::ROLE_PATREON_TIERS as $role => $tier) {
            if (in_array($role, $userRoles)) {
                return $this->json(
                    new Response(200, 'Role found', $tier)
                );
            }
        }

        return $this->json(
            new Response(200, 'User does not have role', 0)
        );
        */
    }
}
