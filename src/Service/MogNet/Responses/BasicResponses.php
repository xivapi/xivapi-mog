<?php

namespace App\Service\MogNet\Responses;

use App\Service\Logic\Context;
use App\Service\MogNet\Messages\Text;
use App\Service\MogNet\Responses\Helpers\TextBuilder;
use App\Service\Translation\Language;
use CharlotteDunois\Yasmin\Models\Message;

class BasicResponses
{
    public static function hello(Message $message)
    {
        $name = $message->member ? $message->member->displayName : $message->author->username;

        return new Text(
            sprintf(Language::Say('HELLO'), $name)
        );
    }

    public static function dice(Message $message)
    {
        $name = $message->member ? $message->member->displayName : $message->author->username;
        $dice = mt_rand(1,999);

        return new Text(
            sprintf(Language::Say('DICE'), $name, $dice)
        );
    }

    public static function help()
    {
        $msg = new TextBuilder();
        $msg->add(Language::Say('HELP_USAGE'))->space();
        $msg->add(Language::Say('HELP_TITLE'));

        foreach (Context::HELP as $command => $constant) {
            // space out the "or"
            $description = Language::Say($constant);
            $command = str_pad($command, 30, ' ', STR_PAD_RIGHT);
            $msg->add("- {$command} {$description}");
        }

        return new Text(
            $msg->code('md')
        );
    }
    
    public static function example()
    {
        return new Text('Example');
    }
}
