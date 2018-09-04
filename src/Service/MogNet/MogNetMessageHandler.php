<?php

namespace App\Service\MogNet;

use App\Service\Logic\Context;
use App\Service\MogNet\Messages\Error;
use App\Service\Translation\Language;
use CharlotteDunois\Yasmin\Models\Message;
use Psr\Log\LoggerInterface;

class MogNetMessageHandler
{
    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Handle the incoming message
     */
    public function handle(Message $message)
    {
        // ignore self
        if ($message->author->tag == getenv('BOT_NAME')) {
            return false;
        }

        $guild = $message->guild ? $message->guild->id : 'DirectMessage';

        // only do things in the main server or via Direct Message
        if (!in_array($guild, ['DirectMessage', '474518001173921794'])) {
            return false;
        }

        $message->isPrivate = $message->guild ? false : true;
        $this->logger->info("[{$guild}] {$message->author->tag}: {$message->content}");

        // only handle messages targeted at the bot (unless it is a dm)
        if (!$message->isPrivate && stripos($message->content, getenv('BOT_MENTION')) !== 0) {
            return false;
        }

        $text = explode(' ', trim(str_ireplace(getenv('BOT_MENTION'), null, $message->content)));
        $text = array_values(array_filter($text));

        return $this->handleRecursive(Context::CONTEXT, $message, $text, 0);
    }

    /**
     * Handle the recursive nature of language trees
     */
    private function handleRecursive(array $contexts, Message $message, array $text, int $wordNum)
    {
        // grab word
        $word = $text[$wordNum] ?? false;

        // loop through contexts
        if ($word) {
            foreach ($contexts as $ctx => $actions) {
                $ctx = explode('|', $ctx);
                foreach ($ctx as $ctxString) {
                    if (stripos($ctxString, $word) !== false) {

                        // if the actions is an array, pass it along
                        if (is_array($actions)) {
                            return $this->handleRecursive($actions, $message, $text, $wordNum + 1);
                        }

                        // else return with the action
                        return $actions($message);
                    }
                }
            }
        }

        // Unknown command (only when not private)
        if (!$message->isPrivate) {
            return new Error(
                sprintf(Language::Say('UNKNOWN_COMMAND'), implode(' ', $text))
            );
        }
    }
}
