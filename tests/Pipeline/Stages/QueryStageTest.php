<?php

namespace Nip\Locale\Detector\Tests\Pipeline\Stages;

use Nip\Locale\Detector\Commands\Command;
use Nip\Locale\Detector\Pipeline\Stages\QueryStage;
use Nip\Locale\Detector\Tests\AbstractTest;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class QueryStageTest
 * @package Nip\Locale\Detector\Tests\Pipeline\Stages
 */
class QueryStageTest extends AbstractTest
{
    /**
     * @param $query
     * @param $locale
     *
     * @dataProvider dataProcessCommand
     * @throws \Nip\Locale\Detector\Exceptions\InvalidLocale
     */
    public function testProcessCommand($query, $locale)
    {
        $request = new Request();
        $request->query->add($query);

        $command = new Command();
        $command->setRequest($request);

        $stage = new QueryStage();
        $stage->setCommand($command);

        $stage->processCommand();

        self::assertSame($locale, $command->getLocale());
    }

    /**
     * @return array
     */
    public function dataProcessCommand()
    {
        return [
            [[], null],
            [['lang' => 'ro'], 'ro'],
            [['lang' => 'en'], 'en'],
            [['language' => 'ro'], 'ro'],
            [['language' => 'en'], 'en'],
        ];
    }
}