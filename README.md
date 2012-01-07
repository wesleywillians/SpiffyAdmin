SpiffyAdmin
========
Version 0.0.1

Introduction
------------
SpiffyAdmin is a module for Zend Framework 2.

Example Definition
------------------
    <?php
    
    namespace Application\Admin;
    
    use SpiffyAdmin\Admin\Definition;
    
    class Profile extends Definition
    {
        public function getName()
        {
            return 'profile';
        }
        
        public function getOptions()
        {
            return array(
                'data_class'   => 'Application\Entity\Profile',
                'display_name' => 'Profile',
                'can_edit'     => true,
                'can_delete'   => true,
                'element_options' => array(
                    'game' => array(
                        'property' => 'name'
                    ),
                    'team' => array(
                        'property' => 'name'
                    ),
                    'meta' => array(
                        'property' => 'key'
                    )
                )
            );
        }
    }
