<?php

namespace SpiffyAdmin\Consumer;

use SpiffyAdmin\Definition\AbstractDefinition;

abstract class AbstractConsumer
{
    /**
     * @var \SpiffyAdmin\Provider\AbstractProvider
     */
    protected $provider;

    public function setProvider($provider)
    {
        $this->provider = $provider;
        return $this;
    }

    public function provider()
    {
        return $this->provider;
    }

    abstract public function getOutput(AbstractDefinition $definition);
}