<?php

namespace App\Service\Translation;

class Language
{
    public static function Say($constant, $language = 'en')
    {
        switch($language) {
            case 'en':
                $ref = new \ReflectionClass(English::class);
                return $ref->getConstant($constant);
        }
        
        return null;
    }

    public static function Words($constant, $language = 'en')
    {
        return self::Say($constant, $language);
    }
}
