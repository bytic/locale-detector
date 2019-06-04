<?php

namespace Nip\Locale\Detector\Tests\Traits;

use Nip\Locale\Detector\Config\Config;
use Nip\Locale\Detector\Detector;
use Nip\Locale\Detector\Tests\AbstractTest;

/**
 * Class HasConfigTraitTest
 * @package Nip\Locale\Detector\Tests\Traits
 */
class HasConfigTraitTest extends AbstractTest
{
    public function testInitConfigTest()
    {
        self::assertInstanceOf(Config::class, Detector::getConfig());
    }

    public function testSetConfigFromArray()
    {
        self::assertInstanceOf(Config::class, Detector::getConfig());

        Detector::setConfigFromArray(['test' => 'value']);

        self::assertTrue(Detector::getConfig()->has('test'));
        self::assertFalse(Detector::getConfig()->has('test1'));
        self::assertSame('value', Detector::getConfigValue('test'));
    }
}
