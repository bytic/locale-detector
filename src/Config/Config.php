<?php

namespace Nip\Locale\Detector\Config;

/**
 * Class Config
 * @package Nip\Locale\Detector\Config
 */
class Config
{
    protected $data = [];

    /**
     * @param $data
     */
    public function init(array $data)
    {
        foreach ($data as $key => $value) {
            $this->set($key, $value);
        }
    }

    /**
     * @param $key
     * @param $value
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * @param $key
     * @param null $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        if (!isset($this->data[$key])) {
            return $default;
        }
        return $this->data[$key];
    }
}
