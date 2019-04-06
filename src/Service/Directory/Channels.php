<?php

namespace App\Service\Directory;

class Channels
{
    const GUILD_ID = 474518001173921794;

    const ANNOUNCEMENTS             = 553592330381426698;
    const DEV_SCHEDULE              = 562943014876610560;
    const CHAT                      = 562943014876610560;
    const PATREON                   = 513681231716810763;

    // GENERAL
    const GENERAL_CHAT              = 474519195963490305;
    const GENERAL_PATREON           = 513681231716810763;
    const GENERAL_FANSITES          = 474519354986332180;
    const GENERAL_BOT_SPAM          = 531971978316349450;
    const GENERAL_FAQ               = 516601420934414337;
    const GENERAL_LODESTONE         = 474586876892676106;

    // API + MOGBOARD
    const DEV_NOTICES               = 534880659026739200;
    const DEV_UPDATES               = 480397609341681685;
    const DEV_BREAKING_CHANGES      = 476708064410468353;
    const DEV_TRELLO                = 476706649990758421;
    const DEV_BUGS                  = 485422007622828042;
    const DEV_GIT_ALERTS            = 474519301865340938;

    // ADMIN
    const ADMIN_BETA                = 477631558317244427;
    const ADMIN_MOG                 = 538316536688017418;
    const ADMIN_TESTING             = 474519472686891018;
    const ADMIN_JOINED              = 474519527846051840;

    // ROLES
    const ROLE_PATREON_HEALER       = 563452038982270989;
    const ROLE_PATREON_DPS          = 563455760869228544;
    const ROLE_PATREON_ADVENTURER   = 563446436176330752;
    const ROLE_PATREON_TANK         = 563453748433649674;
    const ROLE_PATREON_TIERS = [
        self::ROLE_PATREON_DPS        => 4,
        self::ROLE_PATREON_HEALER     => 3,
        self::ROLE_PATREON_TANK       => 2,
        self::ROLE_PATREON_ADVENTURER => 1,
    ];

    /**
     * Get a constant from a string
     */
    public static function get($name)
    {
        return constant(Channels::class . "::" . strtoupper($name));
    }
}
