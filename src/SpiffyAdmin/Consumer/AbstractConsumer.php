<?php

namespace SpiffyAdmin\Consumer;

use SpiffyAdmin\Definition\AbstractDefinition;

abstract class AbstractConsumer
{
    /**
     * @var \SpiffyAdmin\Mapper\AbstractMapper
     */
    protected $mapper;

    public function setMapper($mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }

    public function mapper()
    {
        return $this->mapper;
    }

    abstract public function getOutput(AbstractDefinition $definition);
}