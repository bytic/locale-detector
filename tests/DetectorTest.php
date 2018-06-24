<?php

namespace Nip\Locale\Detector\Tests;

use Nip\Locale\Detector\Detector;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DetectorTest
 * @package Nip\Locale\Detector\Tests
 */
class DetectorTest extends AbstractTest
{
    public function testDetectWithEmptyRequest()
    {
        $request = new Request();

        $locale = Detector::detect($request);
        self::assertSame(null, $locale);
    }

    public function testDetectWithCookie()
    {
        $request = new Request();
        $request->cookies->set('nip_locale', 'ro_RO');

        $locale = Detector::detect($request);
        self::assertSame('ro_RO', $locale);
    }

    public function testDetectWithQuery()
    {
        $request = new Request();
        $request->query->set('lang', 'ro_RO');

        $locale = Detector::detect($request);
        self::assertSame('ro_RO', $locale);
    }
}
