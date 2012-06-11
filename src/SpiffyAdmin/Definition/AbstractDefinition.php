<?php
namespace SpiffyAdmin\Definition;

use InvalidArgumentException;

abstract class AbstractDefinition
{
    protected $name;

    public function __construct(array $options = array())
    {
        $this->options = new Options(array_merge($this->getOptions(), $options));
        $this->validateOptions();
    }

    abstract public function getOptions();

    abstract public function getName();

    public function getCanonicalName()
    {
        return strtolower(str_replace(array('-', '_', ' ', '\\', '/'), '', $this->getName()));
    }

    public function getDisplayName()
    {
        return $this->options()->getDisplayName() ? $this->options()->getDisplayName() : $this->options()->getModel();
    }

    public function options()
    {
        return $this->options;
    }

    protected function validateOptions()
    {
        if (!$this->options()->getModel()) {
            throw new InvalidArgumentException('Options must contain a model to work on.');
        }
    }
}
