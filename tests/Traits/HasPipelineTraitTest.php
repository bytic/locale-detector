<?php

namespace Nip\Locale\Detector\Tests\Traits;

use Nip\Locale\Detector\Detector;
use Nip\Locale\Detector\Tests\AbstractTest;

/**
 * Class HasPipelineTraitTest
 * @package Nip\Locale\Detector\Tests\Traits
 */
class HasPipelineTraitTest extends AbstractTest
{
    public function testCheckPipelineFromConfig()
    {
        $stages = ['alias'];
        Detector::setConfigFromArray(['stages' => $stages]);
        $stagesDetected = Detector::checkPipelineFromConfig(null);
        self::assertSame($stages, $stagesDetected);
    }
}
