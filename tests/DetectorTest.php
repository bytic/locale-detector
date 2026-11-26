<?php

namespace Nip\Locale\Detector\Tests;

use Nip\Locale\Detector\Detector;
use Nip\Locale\Detector\Exceptions\InvalidLocale;
use Nip\Http\Request\PsrRequest;
use Nyholm\Psr7\ServerRequest;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
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

    public function testDetectFromPsrRequestInStageOrder()
    {
        $request = (new ServerRequest('GET', '/'))
            ->withQueryParams(['language' => 'ro_RO'])
            ->withCookieParams(['nip_locale' => 'en_US'])
            ->withHeader('Accept-Language', 'fr-FR, en;q=0.8');

        self::assertSame('ro_RO', Detector::detect($request, [], ['query', 'cookie', 'acceptlanguage']));
        self::assertSame('en_US', Detector::detect($request, [], ['cookie', 'acceptlanguage']));
        self::assertSame('fr_FR', Detector::detect($request, [], ['acceptlanguage']));
    }

    public function testPsrRequestsUseParsedParametersRatherThanUriOrCookieHeader()
    {
        $request = (new ServerRequest('GET', '/?lang=en'))
            ->withHeader('Cookie', 'nip_locale=en')
            ->withQueryParams(['lang' => 'ro'])
            ->withCookieParams(['nip_locale' => 'fr']);

        self::assertSame('ro', Detector::detect($request, [], ['query']));
        self::assertSame('fr', Detector::detect($request, [], ['cookie']));
    }

    public function testPsrRequestWithoutLocaleFallsThrough()
    {
        $request = new ServerRequest('GET', '/');

        self::assertNull(Detector::detect($request, [], ['query', 'cookie', 'acceptlanguage']));
    }

    public function testInvalidPsrParameterIsRejected()
    {
        $request = (new ServerRequest('GET', '/'))
            ->withQueryParams(['lang' => ['en']]);

        $this->expectException(BadRequestException::class);
        Detector::detect($request, [], ['query', 'cookie']);
    }

    public function testPsrAcceptLanguageUsesSymfonyPreferenceOrdering()
    {
        $request = (new ServerRequest('GET', '/'))
            ->withHeader('Accept-Language', 'en-US;q=0.4, ro-RO;q=0.9');

        self::assertSame('ro_RO', Detector::detect($request, [], ['acceptlanguage']));
        self::assertSame(
            (new Request(server: ['HTTP_ACCEPT_LANGUAGE' => $request->getHeaderLine('Accept-Language')]))
                ->getPreferredLanguage(),
            Detector::detect($request, [], ['acceptlanguage'])
        );
    }

    public function testUnsupportedPsrLocaleThrows()
    {
        $request = (new ServerRequest('GET', '/'))->withQueryParams(['lang' => 'ro']);

        $this->expectException(InvalidLocale::class);
        Detector::detect($request, ['en'], ['query']);
    }

    public function testByticPsrRequest()
    {
        $request = new PsrRequest(new Request(query: ['lang' => 'ro']));

        self::assertSame('ro', Detector::detect($request, [], ['query', 'cookie']));
    }
}
