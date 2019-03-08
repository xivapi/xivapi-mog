<?php

namespace App\Service\MogRest;

use RestCord\DiscordClient;

class MogRest
{
    use MogRestTrait;

    public function discord(): DiscordClient
    {
        return new DiscordClient([
            'token' => getenv('BOT_TOKEN')
        ]);
    }

    /**
     * Send a message to a room
     */
    public function sendMessage(int $channel, $message)
    {
        $options = array_merge($this->handleMessage($message), [
            'channel.id' => (int)$channel,
        ]);

        $this->discord()->channel->createMessage($options);
    }

    /**
     * Send a direct message to a user
     */
    public function sendDirectMessage(int $user, $message)
    {
        // create dm
        $dm = $this->discord()->user->createDm([
            'recipient_id' => (int)$user,
        ]);

        $options = array_merge($this->handleMessage($message), [
            'channel.id' => (int)$dm->id
        ]);

        $this->discord()->channel->createMessage($options);
    }

    /**
     * Send a message to a specific role
     */
    public function sendMessageToRole(int $role, int $channel, $message)
    {
        $this->sendMessage($channel, sprintf('<@&%s> %s', $role, $message));
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
