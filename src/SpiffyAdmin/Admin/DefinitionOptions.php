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
     * @var array
     */
    protected $viewProperties = array();
    
    /**
     * @var array
     */
    protected $formProperties = array();
    
    /**
     * @var Closure
     */
    protected $viewClosure;
    
    /**
     * @var string
     */
    protected $editLink;
    
    /**
     * @var string
     */
    protected $editLabel;

    /**
     * @var string
     */
    protected $deleteLink;
    
    /**
     * @var string
     */
    protected $deleteLabel;

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

	/**
     * Get viewProperties
     *
     * @return array
     */
    public function getViewProperties()
    {
        return $this->viewProperties;
    }

	/**
     * Set viewProperties
     *
     * @param array $viewProperties
     * @return SpiffyAdmin\Admin\DefinitionOptions extends Options
     */
    public function setViewProperties($viewProperties)
    {
        $this->viewProperties = $viewProperties;
        return $this;
    }

	/**
     * Get formProperties
     *
     * @return array
     */
    public function getFormProperties()
    {
        return $this->formProperties;
    }

	/**
     * Set formProperties
     *
     * @param array $formProperties
     * @return SpiffyAdmin\Admin\DefinitionOptions extends Options
     */
    public function setFormProperties($formProperties)
    {
        $this->formProperties = $formProperties;
        return $this;
    }

	/**
     * Get viewClosure
     *
     * @return Closure
     */
    public function getViewClosure()
    {
        return $this->viewClosure;
    }

	/**
     * Set viewClosure
     *
     * @param object $viewClosure
     * @return SpiffyAdmin\Admin\DefinitionOptions extends Options
     */
    public function setViewClosure($viewClosure)
    {
        $this->viewClosure = $viewClosure;
        return $this;
    }

	/**
     * Get editLink
     *
     * @return string
     */
    public function getEditLink()
    {
        return $this->editLink;
    }

	/**
     * Set editLink
     *
     * @param string $editLink
     * @return SpiffyAdmin\Admin\DefinitionOptions extends Options
     */
    public function setEditLink($editLink)
    {
        $this->editLink = $editLink;
        return $this;
    }

	/**
     * Get editLabel
     *
     * @return string
     */
    public function getEditLabel()
    {
        return $this->editLabel;
    }

	/**
     * Set editLabel
     *
     * @param string $editLabel
     * @return SpiffyAdmin\Admin\DefinitionOptions extends Options
     */
    public function setEditLabel($editLabel)
    {
        $this->editLabel = $editLabel;
        return $this;
    }

	/**
     * Get deleteLink
     *
     * @return string
     */
    public function getDeleteLink()
    {
        return $this->deleteLink;
    }

	/**
     * Set deleteLink
     *
     * @param string $deleteLink
     * @return SpiffyAdmin\Admin\DefinitionOptions extends Options
     */
    public function setDeleteLink($deleteLink)
    {
        $this->deleteLink = $deleteLink;
        return $this;
    }

	/**
     * Get deleteLabel
     *
     * @return string
     */
    public function getDeleteLabel()
    {
        return $this->deleteLabel;
    }

	/**
     * Set deleteLabel
     *
     * @param string $deleteLabel
     * @return SpiffyAdmin\Admin\DefinitionOptions extends Options
     */
    public function setDeleteLabel($deleteLabel)
    {
        $this->deleteLabel = $deleteLabel;
        return $this;
    }
}