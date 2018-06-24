<?php

namespace Nip\Locale\Detector\Tests\Pipeline;

use League\Pipeline\Pipeline;
use Nip\Locale\Detector\Pipeline\PipelineBuilder;
use Nip\Locale\Detector\Tests\AbstractTest;

/**
 * Class PipelineBuilderTest
 * @package Nip\Locale\Detector\Tests\Pipeline
 */
class PipelineBuilderTest extends AbstractTest
{
    public function testNewFromStagesWithEmptyArray()
    {
        $builder = PipelineBuilder::newFromStages();
        $pipeline = $builder->build();

        self::assertInstanceOf(Pipeline::class, $pipeline);
    }
}
