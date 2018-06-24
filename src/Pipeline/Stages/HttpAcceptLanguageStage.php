<?php

namespace Nip\Locale\Detector\Pipeline\Stages;

use Locale;

/**
 * Class HttpAcceptLanguageStage
 * @package Nip\Dispatcher\Resolver\Pipeline\Stages
 */
class HttpAcceptLanguageStage extends AbstractStage
{
    /**
     * @return void
     */
    public function processCommand()
    {
        if ($this->isHttpRequest() === false) {
            return;
        }

//        $language = $this->getRequest()->getLanguages();
//        foreach ($languages as $language) {
//            if (!$lookup) {
//                return $locale;
//            }
//            if ($match = Locale::lookup($supported, $locale)) {
//                return $match;
//            }
//        }

        $language = $this->getRequest()->getPreferredLanguage();
        $this->getCommand()->setLocale($language);
    }
}
