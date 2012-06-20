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
                'SpiffyAdmin\Provider\DoctrineEntityManager' => function($sm) {
                    return new \SpiffyAdmin\Provider\DoctrineEntityManager(
                        $sm->get('doctrine.entitymanager.orm_default')
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