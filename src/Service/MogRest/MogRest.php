<?php

namespace App\Service\MogRest;

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
    public function sendMessage(int $channel, string $content = null, $embed = null)
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

        $this->discord()->channel->createMessage($options);
    }

    /**
     * Send a direct message
     */
    public function sendDirectMessage(int $user, string $content = null, $embed = null)
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

        $this->discord()->channel->createMessage($options);
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
}
