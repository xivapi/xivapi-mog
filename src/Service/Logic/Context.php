<?php

namespace App\Service\Logic;

use App\Service\MogNet\Responses\BasicResponses;

/**
 * The different commands
 */
class Context
{
    const HELP = [
        'hello'             => 'HELP_OPT_HELLO',
        'dice'              => 'HELP_OPT_DICE',
    ];

    const CONTEXT = [
        '?|help'            => BasicResponses::class .'::help',
        'hello|hi'          => BasicResponses::class .'::hello',
        'dice'              => BasicResponses::class .'::dice',

        // feedback
        'example' => [
            'thing|stuff'   => BasicResponses::class .'::example'
        ]
    ];
}
