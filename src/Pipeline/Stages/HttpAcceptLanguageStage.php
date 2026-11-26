<?php

namespace Nip\Locale\Detector\Pipeline\Stages;

use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class HttpAcceptLanguageStage
 * @package Nip\Dispatcher\Resolver\Pipeline\Stages
 */
class HttpAcceptLanguageStage extends AbstractStage
{
    /**
     * @return void
     * @throws \Nip\Locale\Detector\Exceptions\InvalidLocale
     */
    public function processCommand()
    {
        if ($this->isHttpRequest() === false) {
            return;
        }

        $request = $this->getRequest();
        if ($request instanceof ServerRequestInterface) {
            $request = new Request(server: ['HTTP_ACCEPT_LANGUAGE' => $request->getHeaderLine('Accept-Language')]);
        }

        $language = $request->getPreferredLanguage();
        $this->checkAndSetLocale($language);
    }
}
