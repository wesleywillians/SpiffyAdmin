<?php

namespace SpiffyAdmin\Provider;

use SpiffyAdmin\Definition\AbstractDefinition;

class DoctrineEntityManager extends DoctrineObjectManager
{
    public function findAll(AbstractDefinition $def)
    {
        $options = $def->options()->getProviderOptions();
        $or      = $this->om()->getRepository($def->options()->getModel());

        if (isset($options['query_builder'])) {
            $closure = $options['query_builder'];
            $builder = $closure($or);
            $items   = $builder->getQuery()->execute();
        } else {
            $items = $or->findAll();
        }

        foreach($items as $key => $item) {
            $items[$key] = $this->hydrator()->extract($item);
        }

        return $items;
    }

    protected function persist($object)
    {
        $metadata  = $this->om()->getClassMetadata(get_class($object));
        $reflClass = $metadata->getReflectionClass();

        foreach($reflClass->getProperties() as $property) {
            $property->setAccessible(true);

            if ($metadata->hasAssociation($property->getName())) {
                if (is_numeric($property->getValue($object))) {
                    $target = $metadata->getAssociationTargetClass($property->getName());
                    $value  = $this->om()->getReference($target, $property->getValue($object));

                    $property->setValue($object, $value);
                }
            }
        }

        $this->om()->persist($object);
        $this->om()->flush();
    }
}