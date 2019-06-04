<?php

namespace Nip\Locale\Detector\Traits;

use Nip\Locale\Detector\Config\Config;

/**
 * Trait HasConfigTrait
 * @package Nip\Locale\Detector\Traits
 */
trait HasConfigTrait
{
    protected static $config = null;

    /**
     * @param Config $config
     */
    public function setConfig(Config $config)
    {
        static::$config = $config;
    }

    /**
     * @return Config
     */
    public static function getConfig()
    {
        if (static::$config === null) {
            static::$config = new Config();
        }
        return self::$config;
    }

    /**
     * @param $data
     */
    public function setConfigFromArray($data)
    {
        static::getConfig()->init($data);
    }

    /**
     * @param $key
     * @param null $default
     * @return Config
     */
    public static function getConfigValue($key, $default = null)
    {
        return static::getConfig()->get($key,$default);
    }
}
