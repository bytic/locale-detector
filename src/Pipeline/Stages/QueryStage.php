<?php

namespace Nip\Locale\Detector\Pipeline\Stages;

/**
 * Class QueryStage
 * @package Nip\Dispatcher\Resolver\Pipeline\Stages
 */
class QueryStage extends AbstractStage
{

    /**
     * Default query key
     *
     * @var string
     */
    const QUERY_KEY = 'lang';

    /**
     * Query key to use for request
     *
     * @var string
     */
    protected $queryKey;

    /**
     * Query value to use for request
     *
     * @var string
     */
    protected $queryValue = false;

    /**
     * @return void
     * @throws \Nip\Locale\Detector\Exceptions\InvalidLocale
     */
    public function processCommand()
    {
        if ($this->isHttpRequest() === false) {
            return;
        }

        if ($this->hasQuery()) {
            $this->checkAndSetLocale($this->getQueryValue());
        }
    }

    /**
     * @return bool
     */
    protected function hasQuery()
    {
        return $this->getQueryValue() !== false;
    }

    /**
     * @return bool
     */
    public function generateQueryValue()
    {
        $queryKey = $this->getQueryKey();
        $query = $this->getRequest()->query;
        if ($query->has($queryKey)) {
            $value = $query->get($queryKey);
            return $value;
        }
        return false;
    }

    /**
     * @return string
     */
    public function getQueryKey()
    {
        if (null === $this->queryKey) {
            $this->queryKey = self::QUERY_KEY;
        }
        return $this->queryKey;
    }

    /**
     * @param string $queryKey
     */
    public function setQueryKey($queryKey)
    {
        $this->queryKey = $queryKey;
    }

    /**
     * @return string
     */
    public function getQueryValue()
    {
        if ($this->queryValue === false) {
            $this->setQueryValue($this->generateQueryValue());
        }
        return $this->queryValue;
    }

    /**
     * @param string $queryValue
     */
    public function setQueryValue($queryValue)
    {
        $this->queryValue = $queryValue;
    }
}
