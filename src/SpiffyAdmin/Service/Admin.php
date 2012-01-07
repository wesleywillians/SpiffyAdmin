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
    protected $em;
    
    /**
     * @var SpiffyForm\Form\Manager
     */
    protected $fm;
    
    /**
     * @var SpiffyDataTables\Service\Data
     */
    protected $dataService;
    
    protected $definitions = null;
    
    public function __construct(EntityManager $em, DataService $dataService, FormManager $formManager)
    {
        $this->em = $em;
        $this->fm = $formManager;
        $this->dataService = $dataService;
    }
    
    public function save($entity)
    {
        $this->em->persist($entity);
        $this->em->flush();
    }
    
    public function getFormManager($name, $id = null)
    {
        $def = $this->getDefinition($name);
        
        $this->fm->setEntityManager($this->em);
        
        if (null !== $id) {
             $this->fm->setData($this->getEntity($name, $id));
        } else {
            $class = $def->options()->getDataClass();
            $this->fm->setData(new $class);
        }
             
        // populate form fields
        $reflClass = new ReflectionClass($this->fm->getData());
        foreach($reflClass->getProperties() as $reflProp) {
            $opts    = array();
            $defOpts = $def->options()->getElementOptions();
            
            if (isset($defOpts[$reflProp->getName()])) {
                $opts = $defOpts[$reflProp->getName()];
            }
            $this->fm->add($reflProp->getName(), null, $opts);
        }
         
        $this->fm->add('submit');
             
        return $this->fm;
    }
    
    public function getEntity($name, $id)
    {
        $def = $this->getDefinition($name);
        return $this->em->find($def->options()->getDataClass(), $id);
    }
    
    public function getViewData($name)
    {
        $def  = $this->getDefinition($name);
        
        $qb = $this->em->createQueryBuilder();
        $qb->select('q')
           ->from($def->options()->getDataClass(), 'q');
        
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
        $config = SpiffyAdmin::getOption('definitions')->toArray();
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
            
            $definitions[$def->getName()] = $def;
        }
        
        $this->definitions = $definitions;
        return $this;
    }
}
