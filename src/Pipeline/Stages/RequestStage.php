<?php

namespace Nip\Locale\Detector\Pipeline\Stages;

/**
 * Class ClosureStage
 * @package Nip\Dispatcher\Resolver\Pipeline\Stages
 */
class RequestStage extends AbstractStage
{
    /**
     * @return void
     */
    public function processCommand()
    {
        if (!$this->getCommand()->hasAction() && $this->hasRequestMCA()) {
            $this->saveRequestParamsInCommand();
        }
    }

    protected function saveRequestParamsInCommand()
    {
        $request = $this->getRequest();

        $action = NameFormatter::formatArray(
            $request->getModuleName(),
            $request->getControllerName(),
            $request->getActionName()
        );

        $this->getCommand()->setAction($action);
    }

    /**
     * @return bool
     */
    protected function hasRequestMCA()
    {
        return $this->getCommand()->hasRequest() && $this->getRequest()->getControllerName() !== null;
    }

    /**
     * @return \Nip\Request
     */
    protected function getRequest()
    {
        return $this->getCommand()->getRequest();
    }
}
