<?php
namespace SpiffyAdmin\Admin;

use ReflectionClass;

abstract class Definition
{
    protected static $reflClass = array();
    
    protected $options   = null;
    
    abstract public function getName();
    
    public function preSave($object)
    {
        return $object;
    }
    
    public function getDisplayName()
    {
        return $this->options()->getDisplayName() ? $this->options()->getDisplayName() : $this->getName();
    }
    
    public function getReflClass()
    {
        $class = get_class($this);
        if (!isset($this->reflClass[$class])) {
            $this->reflClass[$class] = new ReflectionClass($this->options()->getDataClass());
        }
        return $this->reflClass[$class];
    }
    
    /**
     * Get options for the definition.
     * 
     * @return DefinitionOptions
     */
    public function getOptions()
    {
        return array();
    }
    
    public function options()
    {
        if (null === $this->options) {
            $this->options = new DefinitionOptions($this->getOptions());
        }
        return $this->options;
    }
}
