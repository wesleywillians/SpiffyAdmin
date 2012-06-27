<?php

namespace SpiffyAdmin;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getServiceConfiguration()
    {
        return array(
            'factories' => array(
                'SpiffyAdmin\Mapper\DoctrineDbal' => function($sm) {
                    return new \SpiffyAdmin\Mapper\DoctrineDbal(
                        $sm->get('doctrine.connection.orm_default')
                    );
                },
                'SpiffyAdmin\Mapper\ZendDb' => function($sm) {
                    return new \SpiffyAdmin\Mapper\ZendDb(
                        $sm->get('Zend\Db\Adapter\Adapter')
                    );
                },
                'SpiffyAdmin\Manager' => 'SpiffyAdmin\Service\ManagerFactory'
            )
        );
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}