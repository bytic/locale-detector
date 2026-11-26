<?php

namespace Nip\Locale\Detector;

use Nip\Locale\Detector\Commands\CommandFactory;
use Nip\Locale\Detector\Traits\HasConfigTrait;
use Nip\Locale\Detector\Traits\HasPipelineTrait;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class Detector
 * @package Nip\Locale\Detector
 */
class Detector
{
    use HasConfigTrait;
    use HasPipelineTrait;

    /**
     * @param ServerRequestInterface|Request|null $request
     * @param array $supported
     * @param null|array $stages
     * @return string|null
     */
    public static function detect($request, $supported = [], $stages = null)
    {
        $command = CommandFactory::createFromRequest($request);
        $command->setSupported($supported);
        $pipeline = static::buildPipeline($stages);
        $command = $pipeline->process($command);
        return $command->getLocale();
    }
}
