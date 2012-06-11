<?php

namespace SpiffyAdmin\Service;

use InvalidArgumentException;
use SpiffyAdmin\Definition\AbstractDefinition;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class AdminManagerFactory implements FactoryInterface
{
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config  = $serviceLocator->get('Configuration');
        $defs    = $config['spiffyadmin']['definitions'];
        $am      = new \SpiffyAdmin\Manager;

        $am->setConsumer($serviceLocator->get($config['spiffyadmin']['consumer']));
        $am->setProvider($serviceLocator->get($config['spiffyadmin']['provider']));
        $am->setFormBuilder($serviceLocator->get($config['spiffyadmin']['form_builder']));

        foreach($defs as $def) {
            if (is_string($def)) {
                $def = new $def;
            }

            if (!$def instanceof AbstractDefinition) {
                throw new InvalidArgumentException(
                    'Definitions must be a string or an instance of AbstractDefinition.'
                );
            }

            $am->addDefinition($def);
        }

        return $am;
    }
}