<?php
namespace SpiffyAdmin\Admin;

abstract class Definition
{
    protected $options = null;
    
    abstract public function getName();
    
    public function getDisplayName()
    {
        return $this->options()->getDisplayName() ? $this->options()->getDisplayName() : $this->getName();
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
