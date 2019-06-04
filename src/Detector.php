<?php

namespace Nip\Locale\Detector;

use Nip\Locale\Detector\Commands\CommandFactory;
use Nip\Locale\Detector\Traits\HasConfigTrait;
use Nip\Locale\Detector\Traits\HasPipelineTrait;

/**
 * Class Detector
 * @package Nip\Locale\Detector
 */
class Detector
{
    use HasConfigTrait;
    use HasPipelineTrait;

    /**
     * @param $request
     * @param array $supported
     * @param null|array $stages
     * @return string
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
