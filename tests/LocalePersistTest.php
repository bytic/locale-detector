<?php

namespace Nip\Locale\Detector\Tests;

use IntlDateFormatter;
use Nip\Locale\Detector\LocalePersist;

/**
 * Class LocalePersistTest
 * @package Nip\Locale\Detector\Tests
 */
class LocalePersistTest extends AbstractTest
{
    /**
     * @param $locale
     * @param $value
     * @dataProvider dataSetEnviroment
     */
    public function testSetEnviroment($locale, $value)
    {
        LocalePersist::setEnviroment($locale);
        $dateTimeObj = new \DateTime('next Monday');
        $dateFormatted = IntlDateFormatter::formatObject(
            $dateTimeObj,
            'EEEE',
        );

        self::assertSame($value, $dateFormatted);
    }

    /**
     * @return array
     */
    public function dataSetEnviroment()
    {
        return [
            [null, 'Monday'],
            ['', 'Monday'],
            [false, 'Monday'],
            ['ro', 'luni'],
            ['ro_RO', 'luni'],
            ['ro_ro', 'luni'],
        ];
    }
}
