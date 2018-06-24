<?php

namespace Nip\Locale\Detector\Commands;

use Psr\Http\Message\ServerRequestInterface;

/**
 * Class CommandFactory
 * @package Nip\Locale\Detector\Commands
 */
class CommandFactory
{
    /**
     * @param ServerRequestInterface|null $request
     * @return Command
     */
    public static function createFromRequest(ServerRequestInterface $request = null): Command
    {
        $command = new Command();
        $command->setRequest($request);
        return $command;
    }
}
