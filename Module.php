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
                'SpiffyAdmin\Consumer\DataTablesConsumer' => function($sm) {
                    return new \SpiffyAdmin\Consumer\DataTablesConsumer;
                },
                'SpiffyAdmin\Provider\DoctrineEntityManager' => function($sm) {
                    return new \SpiffyAdmin\Provider\DoctrineEntityManager(
                        $sm->get('doctrine_orm_default_entitymanager')
                    );
                },
                'SpiffyAdmin\FormBuilder\DoctrineEntity' => function($sm) {
                    return new \SpiffyAdmin\FormBuilder\DoctrineEntity(
                        $sm->get('doctrine_orm_default_entitymanager')
                    );
                },
                'SpiffyAdmin\Manager' => 'SpiffyAdmin\Service\AdminManagerFactory'
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