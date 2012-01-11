<?php
return array(
    'spiffyadmin' => array(
        'auth_required' => false,
        'auth_service' => 'zfcuser_auth_service',
        'acl_name' => 'Zend\Acl\Acl',
        'acl_resource' => 'admin',
        
        'definitions' => array(
            'Application\Admin\Developer',
            'Application\Admin\Game',
            'Application\Admin\Profile',
            'Application\Admin\Team',
        )
    ),
    
    'di' => array(
        'instance' => array(
            'alias' => array(
                // controllers
                'spiffyadmin' => 'SpiffyAdmin\Controller\IndexController',
                
                // services
                'spiffyadmin_admin_service' => 'SpiffyAdmin\Service\Admin',
            ),
            
            'spiffyadmin_admin_service' => array(
                'parameters' => array(
                    'entityManager' => 'doctrine_em',
                    'dataService'   => 'spiffydatatables_data_service',
                    'formManager'   => 'spiffy_form_doctrine',
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
                        'regex' => '/view/(?P<model>\w+)',
                        'spec' => '/view/%model%',
                        'defaults' => array(
                            'controller' => 'spiffyadmin',
                            'action'     => 'view'
                        ),
                    ),
                ),
                'add' => array(
                    'type' => 'regex',
                    'options' => array(
                        'regex' => '/(?P<model>\w+)/add',
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
                        'regex' => '/(?P<model>\w+)/(?P<id>\d+)/edit',
                        'spec' => '/%model%/%id%/edit',
                        'defaults' => array(
                            'controller' => 'spiffyadmin',
                            'action'     => 'edit'
                        ),
                    ),
                ),
            ),
        ),
    ),    
);