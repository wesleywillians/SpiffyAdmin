<?php

namespace SpiffyAdmin\Definition;

use Zend\Stdlib\Options as StdlibOptions;

class Options extends StdlibOptions
{
    /**
     * @var string
     */
    protected $displayName;

    /**
     * @var \Zend\Stdlib\Hydrator\HydratorInterface
     */
    protected $hydrator;
    
    /**
     * @var boolean
     */
    protected $canEdit = true;
    
    /**
     * @var boolean
     */
    protected $canDelete = true;
    
    /**
     * @var array
     */
    protected $elementOptions;
    
    /**
     * @var array
     */
    protected $consumerOptions = array();
    
    /**
     * @var array
     */
    protected $formOptions = array();

    /**
     * @var array
     */
    protected $mapperOptions = array();

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
     * @var string
     */
    protected $entityClass;

	/**
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

	/**
     * @param string $displayName
     * @return \SpiffyAdmin\Definition\Options
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
        return $this;
    }

	/**
     * @return boolean
     */
    public function getCanEdit()
    {
        return $this->canEdit;
    }

	/**
     * @param boolean $canEdit
     * @return \SpiffyAdmin\Definition\Options
     */
    public function setCanEdit($canEdit)
    {
        $this->canEdit = $canEdit;
        return $this;
    }

	/**
     * @return boolean
     */
    public function getCanDelete()
    {
        return $this->canDelete;
    }

	/**
     * @param boolean $canDelete
     * @return \SpiffyAdmin\Definition\Options
     */
    public function setCanDelete($canDelete)
    {
        $this->canDelete = $canDelete;
        return $this;
    }
	
	/**
     * @return array
     */
    public function getElementOptions()
    {
        return $this->elementOptions;
    }

	/**
     * @param array $elementOptions
     * @return \SpiffyAdmin\Definition\Options
     */
    public function setElementOptions(array $elementOptions)
    {
        $this->elementOptions = $elementOptions;
        return $this;
    }

	/**
     * @return array
     */
    public function getConsumerOptions()
    {
        return $this->consumerOptions;
    }

	/**
     * @param array $consumerOptions
     * @return \SpiffyAdmin\Definition\Options
     */
    public function setConsumerOptions($consumerOptions)
    {
        $this->consumerOptions = $consumerOptions;
        return $this;
    }

	/**
     * @return array
     */
    public function getFormOptions()
    {
        return $this->formOptions;
    }

	/**
     * @param array $formOptions
     * @return \SpiffyAdmin\Definition\Options
     */
    public function setFormOptions($formOptions)
    {
        $this->formOptions = $formOptions;
        return $this;
    }

	/**
     * @return string
     */
    public function getEditLink()
    {
        return $this->editLink;
    }

	/**
     * @param string $editLink
     * @return \SpiffyAdmin\Definition\Options
     */
    public function setEditLink($editLink)
    {
        $this->editLink = $editLink;
        return $this;
    }

	/**
     * @return string
     */
    public function getEditLabel()
    {
        return $this->editLabel;
    }

	/**
     * @param string $editLabel
     * @return \SpiffyAdmin\Definition\Options
     */
    public function setEditLabel($editLabel)
    {
        $this->editLabel = $editLabel;
        return $this;
    }

	/**
     * @return string
     */
    public function getDeleteLink()
    {
        return $this->deleteLink;
    }

	/**
     * @param string $deleteLink
     * @return \SpiffyAdmin\Definition\Options
     */
    public function setDeleteLink($deleteLink)
    {
        $this->deleteLink = $deleteLink;
        return $this;
    }

	/**
     * @return string
     */
    public function getDeleteLabel()
    {
        return $this->deleteLabel;
    }

	/**
     * @param string $deleteLabel
     * @return \SpiffyAdmin\Definition\Options
     */
    public function setDeleteLabel($deleteLabel)
    {
        $this->deleteLabel = $deleteLabel;
        return $this;
    }

    /**
     * @param string $entityClass
     * @return \SpiffyAdmin\Definition\Options
     */
    public function setEntityClass($entityClass)
    {
        $this->entityClass = $entityClass;
        return $this;
    }

    /**
     * @return string
     */
    public function getEntityClass()
    {
        return $this->entityClass;
    }

    /**
     * @param $mapperOptions
     * @return \SpiffyAdmin\Definition\Options
     */
    public function setMapperOptions($mapperOptions)
    {
        $this->mapperOptions = $mapperOptions;
        return $this;
    }

    /**
     * @return array
     */
    public function getMapperOptions()
    {
        return $this->mapperOptions;
    }

    /**
     * @param \Zend\Stdlib\Hydrator\HydratorInterface $hydrator
     * @return Options
     */
    public function setHydrator($hydrator)
    {
        $this->hydrator = $hydrator;
        return $this;
    }

    /**
     * @return \Zend\Stdlib\Hydrator\HydratorInterface
     */
    public function getHydrator()
    {
        if (null === $this->hydrator) {
            $this->hydrator = new \Zend\Stdlib\Hydrator\ObjectProperty;
        }
        return $this->hydrator;
    }
}