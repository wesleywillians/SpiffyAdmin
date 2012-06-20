<?php
return array(
    'spiffyadmin' => array(
        'definitions'  => array()
    ),

    'controller' => array(
        'classes' => array(
            'spiffyadmin' => 'SpiffyAdmin\Controller\AdminController'
        )
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'spiffyadmin' => __DIR__ . '/../view',
        ),
    ),

    'router' => array(
        'routes' => array(
            'spiffyadmin' => array(
                'priority' => 1,
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
                            'regex' => '/(?P<name>[\w|+]+)',
                            'spec' => '/%name%',
                            'defaults' => array(
                                'controller' => 'spiffyadmin',
                                'action'     => 'view'
                            ),
                        ),
                    ),
                    'add' => array(
                        'type' => 'regex',
                        'options' => array(
                            'regex' => '/(?P<name>[\d\w]+)/add',
                            'spec' => '/%name%/add',
                            'defaults' => array(
                                'controller' => 'spiffyadmin',
                                'action'     => 'add'
                            ),
                        ),
                    ),
                    'edit' => array(
                        'type' => 'regex',
                        'options' => array(
                            'regex' => '/(?P<name>[\w|+]+)/(?P<id>[\d\w]+)/edit',
                            'spec' => '/%name%/%id%/edit',
                            'defaults' => array(
                                'controller' => 'spiffyadmin',
                                'action'     => 'edit'
                            ),
                        ),
                    ),
                    'delete' => array(
                        'type' => 'regex',
                        'options' => array(
                            'regex' => '/(?P<name>[\w|+]+)/(?P<id>[\d\w]+)/delete',
                            'spec' => '/%name%/%id%/delete',
                            'defaults' => array(
                                'controller' => 'spiffyadmin',
                                'action'     => 'delete'
                            ),
                        ),
                    ),
                ),
            ),
        ),
    )
);