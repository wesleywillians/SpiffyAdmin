<?php

namespace SpiffyAdmin\Provider;

use Doctrine\Common\Persistence\ObjectManager;
use SpiffyAdmin\Definition\AbstractDefinition;

abstract class DoctrineObjectManager extends AbstractProvider
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $om;

    /**
     * @var \Zend\Stdlib\Hydrator\HydratorInterface
     */
    protected $hydrator;

    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function create($object)
    {
        $this->persist($object);
    }

    public function update($object)
    {
        $this->persist($object);
    }

    public function delete($object)
    {
        $this->om()->remove($object);
        $this->om()->flush();
    }

    public function find($objectName, $id)
    {
        return $this->om()->getRepository($objectName)->find($id);
    }

    public function findAll(AbstractDefinition $def)
    {
        $or    = $this->om()->getRepository($def->options()->getModel());
        $items = $or->findAll();

        foreach($items as $key => $item) {
            $items[$key] = $this->hydrator()->extract($item);
        }

        return $items;
    }

    abstract protected function persist($object);

    /**
     * @return \Zend\Stdlib\Hydrator\HydratorInterface
     */
    protected function hydrator()
    {
        if (null === $this->hydrator) {
            $this->hydrator = new \Zend\Stdlib\Hydrator\ClassMethods;
        }
        return $this->hydrator;
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    protected function om()
    {
        return $this->om;
    }
}