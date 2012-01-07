<?php

namespace SpiffyAdmin\Controller;

use Zend\Mvc\Controller\ActionController;

class IndexController extends ActionController
{
    public function indexAction()
    {
        $admin = $this->getLocator()->get('spiffyadmin_admin_service');
        return array('definitions' => $admin->getDefinitions());
    }
    
    public function addAction()
    {
        $admin = $this->getLocator()->get('spiffyadmin_admin_service');
        $match = $this->getEvent()->getRouteMatch();
        
        $request = $this->getRequest();
        $manager = $admin->getFormManager(
            $match->getParam('model')
        );
        
        if ($request->isPost() && $manager->isValid($request->post())) {
            $admin->save($manager->getData());
            
            return $this->redirect()->toRoute(
                'spiffyadmin/view',
                array('model' => $match->getParam('model'))
            );
        }
        
        return array(
            'form' => $manager->getForm()
        );
    }
    
    public function editAction()
    {
        $admin = $this->getLocator()->get('spiffyadmin_admin_service');
        $match = $this->getEvent()->getRouteMatch();
        
        $request = $this->getRequest();
        $manager = $admin->getFormManager(
            $match->getParam('model'),
            $match->getParam('id')
        );
        
        if ($request->isPost() && $manager->isValid($request->post())) {
            $admin->save($manager->getData());
            
            return $this->redirect()->toRoute(
                'spiffyadmin/view',
                array('model' => $match->getParam('model'))
            );
        }
        
        return array(
            'form' => $manager->getForm()
        );
    }
    
    public function viewAction()
    {
        $admin = $this->getLocator()->get('spiffyadmin_admin_service');
        $model = $this->getEvent()->getRouteMatch()->getParam('model');
        
        return array(
            'definition' => $admin->getDefinition($model),
            'data'       => $admin->getViewData($model),
            'model'      => $model
        );
    }
}