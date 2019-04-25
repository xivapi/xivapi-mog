<?php

namespace App\Service\MogRest;

use App\Service\Directory\Channels;
use App\Service\Response\Response;
use RestCord\DiscordClient;

class MogRest
{
    const ROLE_FORMAT = '<@&%s> %s';

    private function discord(): DiscordClient
    {
        return new DiscordClient([
            'token' => getenv('BOT_TOKEN')
        ]);
    }

    /**
     * Send a message to a channel
     */
    public function sendMessage(int $channel, string $content = null, $embed = null): Response
    {
        $options = [
            'channel.id' => (int)$channel,
        ];

        if ($content) {
            $options['content'] = $content;
        }

        if ($embed) {
            $options['embed'] = json_decode(json_encode($embed), true);
        }

        try {
            $this->discord()->channel->createMessage($options);
            return new Response(200, 'Message Sent.');
        } catch (\Exception $ex) {
            return new Response($ex->getCode(), 'Could not send message.');
        }
    }

    /**
     * Send a direct message
     */
    public function sendDirectMessage(int $user, string $content = null, $embed = null): Response
    {
        $dm = $this->discord()->user->createDm([
            'recipient_id' => (int)$user,
        ]);

        $options = [
            'channel.id' => (int)$dm->id,
        ];

        if ($content) {
            $options['content'] = $content;
        }

        if ($embed) {
            $options['embed'] = json_decode(json_encode($embed), true);
        }
    
        try {
            $this->discord()->channel->createMessage($options);
            return new Response(200, 'Message Sent.');
        } catch (\Exception $ex) {
            return new Response($ex->getCode(), 'Could not send message.');
        }
    }

    /**
     * Set a guild role name to something.
     */
    public function setGuildRoleName(int $guild, int $role, int $roleName)
    {
        $this->discord()->guild->modifyGuildRole([
            'guild.id'    => (int)$guild,
            'role.id'     => (int)$role,
            'name'        => (int)$roleName,
            'mentionable' => true,
            'hoist'       => true,
        ]);
    }
    
    /**
     * @return \RestCord\Model\Permissions\Role[]
     */
    public function getGuildRoles()
    {
        return $this->discord()->guild->getGuildRoles([
            'guild.id' => Channels::GUILD_ID,
        ]);
    }

    /**
     * Get all users in the channel
     */
    public function getRolesForUser(int $userId)
    {
        $member = $this->discord()->guild->getGuildMember([
            'guild.id' => Channels::GUILD_ID,
            'user.id' => $userId
        ]);

        return $member->roles;
    }
}
