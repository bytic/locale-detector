<?php

namespace Nip\Locale\Detector\Pipeline\Stages;

use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\InputBag;

/**
 * Class CookieStage
 * @package Nip\Dispatcher\Resolver\Pipeline\Stages
 */
class CookieStage extends AbstractStage
{
    const COOKIE_NAME = 'nip_locale';

    /**
     * The name of the cookie.
     *
     * @var string
     */
    protected $cookieName = null;

    /**
     * The value of the cookie locale if detected in the request.
     *
     * @var string
     */
    protected $cookieValue = false;

    /**
     * @return void
     * @throws \Nip\Locale\Detector\Exceptions\InvalidLocale
     */
    public function processCommand()
    {
        if ($this->isHttpRequest() === false) {
            return;
        }

        if ($this->hasCookie()) {
            $this->checkAndSetLocale($this->getCookieValue());
        }
    }

    /**
     * @return string|false
     */
    public function getCookieValue(): string|false
    {
        if ($this->cookieValue === false) {
            $value = $this->generateCookieValue();
            if ($value !== false && $value !== null) {
                $this->setCookieValue($value);
            }
        }
        return $this->cookieValue;
    }

    /**
     * @param string $cookieValue
     */
    public function setCookieValue(string $cookieValue): void
    {
        $this->cookieValue = $cookieValue;
    }

    /**
     * @return mixed
     */
    public function generateCookieValue()
    {
        $cookieName = $this->getCookieName();
        $request = $this->getRequest();
        $cookieJar = $request instanceof ServerRequestInterface ? new InputBag($request->getCookieParams()) : $request->cookies;
        if ($cookieJar->has($cookieName)) {
            return $cookieJar->get($cookieName);
        }
        return false;
    }

    /**
     * @return bool
     */
    protected function hasCookie()
    {
        return $this->getCookieValue() !== false;
    }

    /**
     * @return string
     */
    public function getCookieName(): string
    {
        if (null === $this->cookieName) {
            return self::COOKIE_NAME;
        }
        return (string)$this->cookieName;
    }

    /**
     * @param string $cookieName
     */
    public function setCookieName(string $cookieName): void
    {
        $this->cookieName = $cookieName;
    }
}
