<?php

namespace SpiffyAdmin;

use InvalidArgumentException,
    ReflectionClass,
    Traversable,
    Doctrine\ORM\Query,
    SpiffyAdmin\Admin\Definition,
    SpiffyAdmin\Module as SpiffyAdmin,
    SpiffyAdmin\Mapper\MapperInterface,
    SpiffyDataTables\Service\Data as DataService,
    SpiffyForm\Form\Builder;

class Manager
{
    /**
     * @var array
     */
    protected $builders = array();
    
    /**
     * @var SpiffyDataTables\Service\Data
     */
    protected $dataService;
    
    /**
     * @var array
     */
    protected $definitions = null;
    
    public function __construct(MapperInterface $mapper, DataService $dataService) 
    {
        $this->mapper      = $mapper;
        $this->dataService = $dataService;
    }
    
    public function save($name, $object)
    {
        $this->mapper->save($this->getDefinition($name), $object);
    }
    
    public function getFormBuilder($name, $id = null)
    {
        if (!isset($this->forms[$name])) {
            $def     = $this->getDefinition($name);
            $opts    = $def->options();
            $builder = $this->mapper->getFormBuilder($def);
            
            if (null === $id) {
                $class = $opts->getDataClass();
                $builder->setData(new $class);             
            } else {
                $builder->setData($this->getObject($name, $id));
            }
                 
            // populate form fields
            $elementOptions = $opts->getElementOptions();
            $formProperties = $opts->getFormProperties();
            foreach($def->getReflClass()->getDefaultProperties() as $name => $value) {
                if ($formProperties && !in_array($name, $formProperties)) {
                    continue;
                }
                
                $options = array();
                if (isset($elementOptions[$name])) {
                    $options = $elementOptions[$name];
                }
                $builder->add($name, null, $options);
            }
             
            $builder->add('submit');
            $builder->add('cancel', 'submit', array(
                'label' => 'Discard Changes'
            ));
            
            $this->builders[$name] = $builder;
        }
             
        return $this->builders[$name];
    }
    
    public function getObject($name, $id)
    {
        $def = $this->getDefinition($name);
        
        return $this->mapper->findById($def, $id);
    }
    
    public function getViewData($name)
    {
        $def  = $this->getDefinition($name);
        $opts = $def->options();
        $data = $this->mapper->getViewData($def);
        
        if ($opts->getCanEdit()) {
            $link  = $opts->getEditLink() ? $opts->getEditLink() : sprintf('/admin/%s/%%id%%/edit', $name);
            $label = $opts->getEditLabel() ? $opts->getEditLabel() : 'Edit';
             
            $this->dataService->format($data, array(
               'edit' => array(
                    'type' => 'link',
                    'options' => array(
                        'label' => $label,
                        'link' => $link
                    )
                )
            ));
        }
        
        if ($opts->getCanDelete()) {
            $link  = $opts->getDeleteLink() ? $opts->getDeleteLink() : sprintf('/admin/%s/%%id%%/delete', $name);
            $label = $opts->getDeleteLabel() ? $opts->getDeleteLabel() : 'Delete';
            
            $this->dataService->format($data, array(
               'delete' => array(
                    'type' => 'link',
                    'options' => array(
                        'label' => $label,
                        'link' => $link
                    )
                )
            ));
        }
        
        return $data;
    }
    
    public function getDefinition($name)
    {
        $definitions = $this->getDefinitions();
        if (!isset($definitions[$name])) {
            throw new InvalidArgumentException(sprintf(
                'Definition by the name "%s" could not be located',
                $name
            ));
        }
        
        return $definitions[$name];
    }
    
    public function getDefinitions()
    {
        if (null === $this->definitions) {
            $this->setDefinitions();
        }
        return $this->definitions;
    }
    
    public function setDefinitions(array $defs = array())
    {
        $definitions = array();
        
        foreach($defs as &$def) {
            if (is_string($def)) {
                $def = new $def;
            }
            
            if (!is_object($def)) {
                throw new InvalidArgumentException('object expected');
            }
            
            if (!$def instanceof Definition) { 
                throw new InvalidArgumentException(sprintf(
                    'Definition must be an instance of SpiffyAdmin\Admin\Definition, got %s',
                    get_class($def) 
                ));
            }

            // verify options
            if (!$def->options()->getDataClass()) {
                throw new InvalidArgumentException('data_class is required');
            }
            
            // set properties
            $properties = count($def->options()->getViewProperties()) ? 
                $def->options()->getViewProperties() : 
                array_keys($def->getReflClass()->getDefaultProperties());
                
            foreach($properties as $name => $options) {
                if (is_string($options)) {
                    unset($properties[$name]);
                    
                    $name    = $options;
                    $options = array();
                }
                
                if (!isset($options['label'])) {
                    $options['label'] = ucfirst($name);
                }
                $options['property'] = $name;
                
                $properties[$name] = $options;
            }
            
            $def->options()->setViewProperties($properties);
            $definitions[$def->getName()] = $def;
        }
        
        $this->definitions = $definitions;
        return $this;
    }
}
