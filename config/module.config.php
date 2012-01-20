<?php
return array(
    'spiffyadmin' => array(
        'definitions' => array(
        )
    ),
    
    'di' => array(
        'instance' => array(
            'alias' => array(
                // controllers
                'spiffyadmin'      => 'SpiffyAdmin\Controller\IndexController',
                'spiffyadmin_crud' => 'SpiffyAdmin\Controller\CrudController',
                
                // managers
                'spiffyadmin_manager' => 'SpiffyAdmin\Manager',
                
				// mappers
				'spiffyadmin_mongo_mapper' => 'SpiffyAdmin\Mapper\DoctrineMongoODM',
            ),
            'spiffyadmin_mongo_mapper' => array(
                'parameters' => array(
                    'dm'      => 'mongo_dm',
                    'builder' => 'spiffyform_builder_mongo',
                )
            ),
            'spiffyadmin' => array(
                'parameters' => array(
                    'adminManager' => 'spiffyadmin_manager'
                )
            ),
            'spiffyadmin_crud' => array(
                'parameters' => array(
                    'adminManager' => 'spiffyadmin_manager'
                )
            ),
            'spiffyadmin_manager' => array(
                'parameters' => array(
                    'mapper'      => 'spiffyadmin_mongo_mapper',
                    'dataService' => 'spiffydatatables_data_service'
                )
            ),
            'Zend\View\PhpRenderer' => array(
                'parameters' => array(
                    'options' => array(
                        'script_paths' => array(
                            'spiffyadmin' => __DIR__ . '/../views',
                        ),
                    ),
                ),
            ),
        ),
    ),
    'routes' => array(
        'spiffyadmin' => array(
            'type' => 'literal',
            'options' => array(
                'route'    => '/admin',
                'defaults' => array(
                    'controller' => 'spiffyadmin',
                    'action'     => 'index',
                ),
            ),
            'may_terminate' => true,
            'child_routes'  => array(
                'view' => array(
                    'type' => 'regex',
                    'options' => array(
                        'regex' => '/(?P<model>\w+)',
                        'spec' => '/%model%',
                        'defaults' => array(
                            'controller' => 'spiffyadmin',
                            'action'     => 'view'
                        ),
                    ),
                ),
                'add' => array(
                    'type' => 'regex',
                    'options' => array(
                        'regex' => '/(?P<model>[\d\w]+)/add',
                        'spec' => '/%model%/add',
                        'defaults' => array(
                            'controller' => 'spiffyadmin',
                            'action'     => 'add'
                        ),
                    ),
                ),                
                'edit' => array(
                    'type' => 'regex',
                    'options' => array(
                        'regex' => '/(?P<model>\w+)/(?P<id>[\d\w]+)/edit',
                        'spec' => '/%model%/%id%/edit',
                        'defaults' => array(
                            'controller' => 'spiffyadmin',
                            'action'     => 'edit'
                        ),
                    ),
                ),
                'delete' => array(
                    'type' => 'regex',
                    'options' => array(
                        'regex' => '/(?P<model>\w+)/(?P<id>[\d\w]+)/delete',
                        'spec' => '/%model%/%id%/delete',
                        'defaults' => array(
                            'controller' => 'spiffyadmin',
                            'action'     => 'delete'
                        ),
                    ),
                ),
            ),
        ),
    ),    
);