<?php

namespace Nip\Locale\Detector\Pipeline;

use League\Pipeline\InterruptibleProcessor;
use League\Pipeline\PipelineBuilder as AbstractBuilder;
use League\Pipeline\PipelineInterface;
use League\Pipeline\ProcessorInterface;
use Nip\Locale\Detector\Commands\Command;
use Nip\Locale\Detector\Exceptions\InvalidPipelineAlias;
use Nip\Locale\Detector\Pipeline\Stages\CookieStage;
use Nip\Locale\Detector\Pipeline\Stages\HttpAcceptLanguageStage;
use Nip\Locale\Detector\Pipeline\Stages\QueryStage;

/**
 * Class MethodsPipeline
 * @package Nip\Dispatcher\Resolver\Pipeline
 */
class PipelineBuilder extends AbstractBuilder
{
    protected static $aliases = [
        'query' => QueryStage::class,
//        'uripath'        => UriPathStrategy::class,
//        'host'           => HostStrategy::class,
        'cookie' => CookieStage::class,
        'acceptlanguage' => HttpAcceptLanguageStage::class,
//        'asset'          => AssetStrategy::class,
    ];

    /**
     * @param $stages
     * @return PipelineBuilder
     */
    public static function newFromStages($stages = null)
    {
        $builder = new static();
        $builder->initStagesFromArray($stages);
        return $builder;
    }

    /**
     * @param null $stages
     * @throws InvalidPipelineAlias
     */
    public function initStagesFromArray($stages = null)
    {
        $stages = is_array($stages) ? $stages : static::getDefaultStages();
        $this->addStagesFromAlias($stages);
    }

    /**
     * @param $stages
     * @throws InvalidPipelineAlias
     */
    protected function addStagesFromAlias($stages)
    {
        foreach ($stages as $alias) {
            if (!isset(static::$aliases)) {
                throw new InvalidPipelineAlias();
            }

            $class = static::$aliases[$alias];
            if (class_exists($class) === false) {
                throw new InvalidPipelineAlias();
            }
            $this->add(new $class());
        }
    }

    /**
     * @return array
     */
    public static function getDefaultStages()
    {
        return array_keys(static::$aliases);
    }

    /**
     * Build a new Pipeline object
     *
     * @param ProcessorInterface|null $processor
     *
     * @return PipelineInterface
     */
    public function build(ProcessorInterface $processor = null): PipelineInterface
    {
        if ($processor == null) {
            $processor = new InterruptibleProcessor(
                function (Command $command) {
                    return !$command->hasLocale();
                }
            );
        }
        return parent::build($processor);
    }
}
