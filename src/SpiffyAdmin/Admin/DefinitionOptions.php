<?php

namespace SpiffyAdmin\Admin;

use Zend\Stdlib\Options;

class DefinitionOptions extends Options
{
    /**
     * @var string
     */
    protected $dataClass;
    
    /**
     * @var string
     */
    protected $displayName;
    
    /**
     * @var boolean
     */
    protected $canEdit;
    
    /**
     * @var boolean
     */
    protected $canDelete;
    
    /**
     * @var array
     */
    protected $elementOptions;

	/**
     * Get dataClass
     *
     * @return string
     */
    public function getDataClass()
    {
        return $this->dataClass;
    }

	/**
     * Set dataClass
     *
     * @param string $dataClass
     * @return SpiffyAdmin\Admin\DefinitionOptions
     */
    public function setDataClass($dataClass)
    {
        $this->dataClass = $dataClass;
        return $this;
    }

	/**
     * Get displayName
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

	/**
     * Set displayName
     *
     * @param string $displayName
     * @return SpiffyAdmin\Admin\DefinitionOptions
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
        return $this;
    }

	/**
     * Get canEdit
     *
     * @return boolean
     */
    public function getCanEdit()
    {
        return $this->canEdit;
    }

	/**
     * Set canEdit
     *
     * @param boolean $canEdit
     * @return SpiffyAdmin\Admin\DefinitionOptions
     */
    public function setCanEdit($canEdit)
    {
        $this->canEdit = $canEdit;
        return $this;
    }

	/**
     * Get canDelete
     *
     * @return boolean
     */
    public function getCanDelete()
    {
        return $this->canDelete;
    }

	/**
     * Set canDelete
     *
     * @param boolean $canDelete
     * @return SpiffyAdmin\Admin\DefinitionOptions
     */
    public function setCanDelete($canDelete)
    {
        $this->canDelete = $canDelete;
        return $this;
    }
	
	/**
     * Get element options
     *
     * @return array
     */
    public function getElementOptions()
    {
        return $this->elementOptions;
    }

	/**
     * Set element options
     *
     * @param array $elementOptions
     * @return SpiffyAdmin\Admin\DefinitionOptions
     */
    public function setElementOptions(array $elementOptions)
    {
        $this->elementOptions = $elementOptions;
        return $this;
    }
}