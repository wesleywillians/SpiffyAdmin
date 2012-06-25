<?php

namespace SpiffyAdmin\Service;

use InvalidArgumentException;
use SpiffyAdmin\Definition\AbstractDefinition;
use SpiffyAdmin\Manager;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ManagerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sl)
    {
        $config  = $sl->get('Configuration');
        $manager = new Manager($config['spiffyadmin']);

        return $this->setupManager($sl, $manager);
    }

    protected function setupManager(ServiceLocatorInterface $sl, Manager $manager)
    {
        $consumer = $manager->options()->getConsumer();
        if ($sl->has($consumer)) {
            $consumer = $sl->get($consumer);
        } else {
            $consumer = new $consumer;
        }
        $manager->setConsumer($consumer);

        $mapper = $manager->options()->getMapper();
        if ($sl->has($mapper)) {
            $mapper = $sl->get($mapper);
        } else {
            $mapper = new $mapper;
        }
        $manager->setMapper($mapper);

        $builder = $manager->options()->getFormBuilder();
        if ($sl->has($builder)) {
            $builder = $sl->get($builder);
        } else {
            $builder = new $builder;
        }
        $manager->setFormBuilder($builder);

        foreach($manager->options()->getDefinitions() as $def) {
            if (is_string($def)) {
                if ($sl->has($def)) {
                    $def = $sl->get($def);
                } else {
                    $def = new $def;
                }
            }

            if (!$def instanceof AbstractDefinition) {
                throw new InvalidArgumentException(
                    'Definitions must be a string or an instance of AbstractDefinition.'
                );
            }

            $manager->addDefinition($def);
        }

        return $manager;
    }
}