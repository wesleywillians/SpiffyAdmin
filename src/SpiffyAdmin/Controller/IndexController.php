<?php

namespace SpiffyAdmin\Controller;

use SpiffyAdmin\Module as SpiffyAdmin;

class IndexController extends CrudController
{
    public function indexAction()
    {
        return array('definitions' => $this->getAdminManager()->getDefinitions());
    }
    
    public function addAction()
    {
        $match       = $this->getEvent()->getRouteMatch();
        $this->model = $match->getParam('model');
        
        return parent::addAction();
    }
    
    public function editAction()
    {
        $match       = $this->getEvent()->getRouteMatch();
        $this->model = $match->getParam('model');
        $this->id    = $match->getParam('id');
        
        return parent::editAction();
    }
    
    public function viewAction()
    {
        $this->model = $this->getEvent()->getRouteMatch()->getParam('model');
        
        return parent::viewAction();
    }
    
    public function getDefinitions()
    {
        return SpiffyAdmin::getOption('definitions')->toArray();
    }
    
    public function redirectToView()
    {
        return $this->redirect()->toRoute(
            'spiffyadmin/view',
            array('model' => $this->model)
        ); 
    }
}