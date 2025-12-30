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
        $locale = \Locale::canonicalize($locale);
        self::setEnviroment($locale);
        self::persistInCookie($locale);
    }

    /**
     * @param $locale
     */
    public static function setEnviroment($locale)
    {
        if (empty($locale)) {
            return;
        }
        $locale = \Locale::canonicalize($locale);

        setlocale(LC_ALL, $locale);
        setlocale(LC_NUMERIC, 'C');
    }

    /**
     * @param $locale
     */
    protected static function persistInCookie($locale)
    {
        setcookie(CookieStage::COOKIE_NAME, $locale, time() + (86400 * 30), "/");
    }
}
