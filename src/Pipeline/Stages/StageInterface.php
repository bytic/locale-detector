<?php

namespace Nip\Locale\Detector\Pipeline\Stages;

use Nip\Locale\Detector\Commands\Command;

/**
 * Interface StageInterface
 * @package Nip\Locale\Detector\Pipeline\Stages
 */
interface StageInterface
{
    /**
     * @param Command $methodCall
     * @return Command
     */
    public function __invoke(Command $methodCall): Command;
}
