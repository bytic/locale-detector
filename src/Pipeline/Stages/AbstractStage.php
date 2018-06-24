<?php

namespace Nip\Locale\Detector\Pipeline\Stages;

use Nip\Locale\Detector\Commands\Command;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class AbstractStage
 * @package Nip\Locale\Detector\Pipeline\Stages
 */
abstract class AbstractStage implements StageInterface
{
    /**
     * @var Command
     */
    protected $command;

    /**
     * @param Command $command
     * @return Command
     */
    public function __invoke(Command $command): Command
    {
        $this->setCommand($command);
        $this->processCommand();
        return $command;
    }

    /**
     * @return void
     */
    abstract public function processCommand();

    /**
     * @return Command
     */
    public function getCommand(): Command
    {
        return $this->command;
    }

    /**
     * @param Command $command
     */
    public function setCommand(Command $command)
    {
        $this->command = $command;
    }

    /**
     * @return \Psr\Http\Message\ServerRequestInterface|\Symfony\Component\HttpFoundation\Request
     */
    protected function getRequest()
    {
        return $this->getCommand()->getRequest();
    }

    /**
     * @param $locale
     * @throws \Nip\Locale\Detector\Exceptions\InvalidLocale
     */
    protected function checkAndSetLocale($locale)
    {
        if ($this->isValidLocaleString($locale)) {
            $this->getCommand()->setLocale($locale);
        }
    }

    /**
     * @param $locale
     * @return bool
     */
    protected function isValidLocaleString($locale)
    {
        if (empty($locale)) {
            return false;
        }
        return true;
    }

    /**
     * @return bool
     */
    protected function isHttpRequest()
    {
        return $this->getRequest() instanceof Request;
    }
}
