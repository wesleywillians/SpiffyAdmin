<?php

namespace SpiffyAdmin\Service;

use InvalidArgumentException;
use SpiffyAdmin\Definition\AbstractDefinition;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class ManagerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $sl)
    {
        $config  = $sl->get('Configuration');
        $manager = new \SpiffyAdmin\Manager($config['spiffyadmin']);

        $consumer = $manager->options()->getConsumer();
        if ($sl->has($consumer)) {
            $consumer = $sl->get($consumer);
        } else {
            $consumer = new $consumer;
        }
        $manager->setConsumer($consumer);

        $provider = $manager->options()->getProvider();
        if ($sl->has($provider)) {
            $provider = $sl->get($provider);
        } else {
            $provider = new $provider;
        }
        $manager->setProvider($provider);

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