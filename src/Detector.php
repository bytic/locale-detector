<?php

namespace Nip\Locale\Detector;

use Nip\Locale\Detector\Commands\CommandFactory;

/**
 * Class Detector
 * @package Nip\Locale\Detector
 */
class Detector
{

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

    /**
     * @param null $stages
     * @return \League\Pipeline\Pipeline|\League\Pipeline\PipelineInterface
     */
    protected static function buildPipeline($stages = null)
    {
        $pipeline = Pipeline\PipelineBuilder::newFromStages($stages);
        return $pipeline->build();
    }
}
