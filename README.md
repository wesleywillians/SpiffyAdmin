SpiffyAdmin
========
Version 0.0.1

Introduction
------------
SpiffyAdmin is a module for Zend Framework 2. This module is still under heavy development - use at 
your own risk.

Example Definition
------------------
    <?php

    namespace Application\Admin;

    use SpiffyAdmin\Definition\AbstractDefinition;

    class ProfileDefinition extends AbstractDefinition
    {
        public function getOptions()
        {
            return array(
                'display_name' => 'Profile',
                'model' => 'Application\Entity\Profile',
                'form_options' => array(
                    'elements' => array(
                        'name',
                        'game',
                        'user'
                    )
                ),
                'consumer_options' => array(
                    'columns' => array(
                        'id' => array(
                            'attributes' => array(
                                'sTitle' => 'ID'
                            )
                        ),
                        'name' => array(
                            'attributes' => array(
                                'sTitle' => 'Name'
                            )
                        ),
                        'token' => array(
                            'type' => 'token',
                            'config' => array(
                                'format' => 'I am a %name% with an %id%',
                            ),
                            'attributes' => array(
                                'sTitle' => 'Token'
                            )
                        ),
                        'game' => array(
                            'type' => 'closure',
                            'config' => array(
                                'closure' => function($def, $data) {
                                    return $data['game']->getName();
                                }
                            ),
                            'attributes' => array(
                                'sTitle' => 'Game'
                            ),
                        ),
                        'user' => array(
                            'type' => 'closure',
                            'config' => array(
                                'closure' => function($def, $data) {
                                    return $data['user']->getEmail();
                                }
                            ),
                            'attributes' => array(
                                'sTitle' => 'User',
                            )
                        )
                    )
                )
            );
        }

        public function getName()
        {
            return 'profile';
        }
    }
