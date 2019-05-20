<?php

namespace Nip\Locale\Detector;

use Nip\Locale\Detector\Pipeline\Stages\CookieStage;

/**
 * Class LocalePersist
 * @package Nip\Locale\Detector
 */
class LocalePersist
{
    /**
     * @param $locale
     */
    public static function persist($locale)
    {
        self::setEnviroment($locale);
        self::persistInCookie($locale);
    }

    /**
     * @param $locale
     */
    public static function setEnviroment($locale)
    {
        setlocale(LC_ALL, $locale);
        setlocale(LC_NUMERIC, 'en_US');
    }

    /**
     * @param $locale
     */
    protected static function persistInCookie($locale)
    {
        $_COOKIE[CookieStage::COOKIE_NAME] = $locale;
    }
}
