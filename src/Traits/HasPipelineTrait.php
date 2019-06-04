<?php

namespace Nip\Locale\Detector\Traits;

use Nip\Locale\Detector\Pipeline\PipelineBuilder;

/**
 * Trait HasPipelineTrait
 * @package Nip\Locale\Detector\Traits
 */
trait HasPipelineTrait
{

    /**
     * @param null $stages
     * @return \League\Pipeline\Pipeline|\League\Pipeline\PipelineInterface
     */
    protected static function buildPipeline($stages = null)
    {
        $stages = static::checkPipelineFromConfig($stages);
        $pipeline = PipelineBuilder::newFromStages($stages);
        return $pipeline->build();
    }

    /**
     * @param $stages
     * @return |null
     */
    public static function checkPipelineFromConfig($stages)
    {
        if (is_array($stages) && count($stages)) {
            return $stages;
        }
        if (static::getConfig()->has('stages')) {
            return static::getConfig()->get('stages');
        }
        return null;
    }
}
