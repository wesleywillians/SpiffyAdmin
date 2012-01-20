<?php

namespace SpiffyAdmin\Mapper;

use Doctrine\ODM\MongoDB\DocumentManager,
    SpiffyAdmin\Admin\Definition,
    SpiffyAdmin\Mapper\MapperInterface,
    SpiffyForm\Form\Builder\DoctrineMongoODM as FormBuilder;

class DoctrineMongoODM implements MapperInterface
{
    /**
     * @var Doctrine\ODM\MongoDB\DocumentManager
     */
    protected $dm;
    
    /**
     * @var SpiffyForm\Form\Builder
     */
    protected $builder;
    
    public function __construct(DocumentManager $dm, FormBuilder $builder)
    {
        $this->dm      = $dm;
        $this->builder = $builder;
    }
    
    public function findById(Definition $def, $id)
    {
        $dr = $this->dm->getRepository($def->options()->getDataClass());
        return $dr->find($id);
    }
    
    public function getViewData(Definition $def)
    {
        if ($def->options()->getViewClosure()) {
            $closure = $def->options()->getViewClosure();
            $qb = $closure($this->dm->getRepository($def->options()->getDataClass()));
        } else {
            $qb = $this->dm->createQueryBuilder(
                $def->options()->getDataClass()
            );
        }
            
        $cur = $qb->getQuery()
                  ->execute();
        
        $reflClass = $def->getReflClass();
        $viewProps = array_keys($def->options()->getViewProperties());
        
        $data = array();
        foreach($cur as $obj) {
            $item = array();
            foreach($viewProps as $prop) {
                $getter = 'get' . ucfirst($prop);

                if (method_exists($obj, $getter)) {
                    $value = $obj->$getter();
                } else if (($vars = get_object_vars($obj)) && array_key_exists($prop, $vars)) {
                    $value = $obj->$prop;
                } else {
                    $reflProp = $reflClass->getProperty($prop);
                    $reflProp->setAccessible(true);

                    $value = $reflProp->getValue($obj);
                }
                
                $item[$prop] = $value;
            }
            $data[] = $item;
        }
        
        return $data;
    }
    
    public function getFormBuilder(Definition $def)
    {
        return $this->builder;
    }
    
    public function save(Definition $def, $object)
    {
        $object = $def->preSave($object);
        
        $this->dm->persist($object);
        $this->dm->flush();
    }
}
