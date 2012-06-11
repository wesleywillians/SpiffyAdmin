<?php
namespace SpiffyAdmin\Definition;

use InvalidArgumentException;

abstract class AbstractDefinition
{
    /**
     * @var \SpiffyAdmin\Definition\Options
     */
    protected $options;

    abstract public function getDefaultOptions();

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
        if (null === $this->options) {
            $this->options = new Options($this->getDefaultOptions());
            $this->validateOptions();
        }
        return $this->options;
    }

    protected function validateOptions()
    {
        if (!$this->options()->getModel()) {
            throw new InvalidArgumentException('Options must contain a model to work on.');
        }
    }
}
