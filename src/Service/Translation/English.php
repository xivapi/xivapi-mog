<?php

namespace App\Service\Translation;

class English
{
    // These are a list of words that mean "stop" which tell the bot to stop doing its current action
    const STOP = [
        'stop','ignore','nvm','end','close','cancel'
    ];

    const YES = 'yes';
    const NO = 'no';

    // Random
    const HELLO = 'Hello %s!';
    const DICE = '%s rolled a **%s**';

    // help
    const HELP_USAGE = '> Usage: @mognet <command>';
    const HELP_TITLE = '# Commands (Those listed with a / are interchangeable):';

    const HELP_OPT_HELLO = 'Says hello to you!';
    const HELP_OPT_DICE = 'Rolls the dice and gives you a random number between 1 and 999';
    const HELP_OPT_FEEDBACK = 'Report a bug or issue on XIVDB';

    // errors
    const UNKNOWN_COMMAND = '_I am not sure how to respond to: %s - Try "help" to learn more about what I can do._';
}
