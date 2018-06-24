<?php

namespace Nip\Locale\Detector\Commands;

use Nip\Locale\Detector\Exceptions\InvalidLocale;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Command
 * @package Nip\Locale\Detector\Commands
 */
class Command
{
    /**
     * @var ServerRequestInterface|Request
     */
    protected $request;

    protected $supported = null;

    protected $locale = null;

    /**
     * @return ServerRequestInterface|Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param ServerRequestInterface|Request $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param mixed $locale
     * @throws InvalidLocale
     */
    public function setLocale($locale)
    {
        if ($this->isSupported($locale) == false) {
            throw new InvalidLocale();
        }
        $this->locale = $locale;
    }

    /**
     * @return bool
     */
    public function hasLocale()
    {
        return $this->getLocale() !== null;
    }

    /**
     * @return null
     */
    public function getSupported()
    {
        return $this->supported;
    }

    /**
     * @param null $supported
     */
    public function setSupported($supported): void
    {
        $this->supported = $supported;
    }

    /**
     * @return bool
     */
    public function hasSupported()
    {
        return is_array($this->supported) && count($this->supported);
    }

    /**
     * @param $locale
     * @return bool
     */
    public function isSupported($locale)
    {
        if ($this->hasSupported()) {
            return in_array($locale, $this->getSupported());
        }
        return true;
    }
}
