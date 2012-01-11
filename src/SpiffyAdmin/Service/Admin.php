<?php

namespace SpiffyAdmin\Service;

use InvalidArgumentException,
    ReflectionClass,
    Traversable,
    Doctrine\ORM\EntityManager,
    Doctrine\ORM\Query,
    SpiffyAdmin\Admin\Definition,
    SpiffyAdmin\Module as SpiffyAdmin,
    SpiffyDataTables\Service\Data as DataService,
    SpiffyForm\Form\Manager as FormManager;

class Admin
{
    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $entityManager;
    
    /**
     * @var SpiffyForm\Form\Manager
     */
    protected $formManager;
    
    /**
     * @var SpiffyDataTables\Service\Data
     */
    protected $dataService;
    
    /**
     * @var array
     */
    protected $definitions = null;
    
    public function __construct(
        EntityManager $entityManager,
        DataService $dataService,
        FormManager $formManager
    ) {
        $this->entityManager = $entityManager;
        $this->formManager   = $formManager;
        $this->dataService   = $dataService;
    }
    
    public function save($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }
    
    public function getFormManager($name, $id = null)
    {
        $def = $this->getDefinition($name);
        
        $this->formManager->setEntityManager($this->entityManager);
        
        if (null !== $id) {
             $this->formManager->setData($this->getEntity($name, $id));
        } else {
            $class = $def->options()->getDataClass();
            $this->formManager->setData(new $class);
        }
             
        // populate form fields
        $reflClass = new ReflectionClass($this->formManager->getData());
        foreach($reflClass->getProperties() as $reflProp) {
            $opts    = array();
            $defOpts = $def->options()->getElementOptions();
            
            if (isset($defOpts[$reflProp->getName()])) {
                $opts = $defOpts[$reflProp->getName()];
            }
            $this->formManager->add($reflProp->getName(), null, $opts);
        }
         
        $this->formManager->add('submit');
             
        return $this->formManager;
    }
    
    public function getEntity($name, $id)
    {
        $def = $this->getDefinition($name);
        return $this->entityManager->find($def->options()->getDataClass(), $id);
    }
    
    public function getViewData($name)
    {
        $def = $this->getDefinition($name);
        
        $qb = $this->entityManager->createQueryBuilder();
        $qb->from($def->options()->getDataClass(), 'q');
        
        if (count($def->options()->getViewProperties()) > 0) {
            $qb->select('partial q.{' . implode(',', array_keys($def->options()->getViewProperties())) . '}');
        } else {
            $qb->select('q');
        }
        
        $data = $qb->getQuery()->execute(array(), Query::HYDRATE_ARRAY);
        
        if ($def->options()->getCanEdit()) {
            $this->dataService->format($data, array(
               'edit' => array(
                    'type' => 'link',
                    'options' => array(
                        'label' => 'Edit',
                        'link' => sprintf('/admin/%s/%%id%%/edit', $name)
                    )
                )
            ));
        }
        
        if ($def->options()->getCanDelete()) {
            $this->dataService->format($data, array(
               'delete' => array(
                    'type' => 'link',
                    'options' => array(
                        'label' => 'Delete',
                        'link' => sprintf('/admin/%s/%%id%%/delete', $name)
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
    
    public function setDefinitions()
    {
        $definitions = array();
        $config      = SpiffyAdmin::getOption('definitions')->toArray();
        foreach($config as &$def) {
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
            
            $mdata = $this->entityManager->getClassMetadata($def->options()->getDataClass());

            // set properties
            $properties = count($def->options()->getViewProperties()) ? 
                $def->options()->getViewProperties() : 
                array_keys($mdata->fieldNames);
                
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
