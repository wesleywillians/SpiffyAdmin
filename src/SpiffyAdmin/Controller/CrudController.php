<?php

namespace SpiffyAdmin\Controller;

use RuntimeException,
    SpiffyAdmin\Module as SpiffyAdmin,
    SpiffyAdmin\Manager as AdminManager,
    Zend\Mvc\Controller\ActionController;

abstract class CrudController extends ActionController
{
    protected $model = null;
    protected $id    = null;
    
    /**
     * @var SpiffyAdmin\Manager
     */
    protected $adminManager;
    
    abstract public function redirectToView();
    
    public function processForm($id = null)
    {
        if (!$this->model) {
            throw new RuntimeException('No model was set for CrudController::processForm');
        }
        
        $admin   = $this->getAdminManager();
        $request = $this->getRequest();
        
        $builder = $admin->getFormBuilder($this->model, $id);
        
        if ($request->isPost() && $builder->isValid($request->post())) {
            $admin->save($this->model, $builder->getData());
            
            return $this->redirectToView();
        }
        
        return array(
            'definition' => $admin->getDefinition($this->model),
            'form'       => $builder->getForm()
        );
    }
    
    public function getDefinitions()
    {
        return array();
    }
    
    public function setAdminManager(AdminManager $adminManager)    
    {
        $adminManager->setDefinitions($this->getDefinitions());
        
        $this->adminManager = $adminManager;
        return $this;
    }
    
    public function getAdminManager()
    {
        return $this->adminManager;
    }
    
    public function indexAction()
    {
        return $this->viewAction();
    }
    
    public function addAction()
    {
        return $this->processForm();
    }
    
    public function editAction()
    {
        if (!$this->id) {
            throw new RuntimeException('No id was set for CrudController::editAction');
        }
        
        return $this->processForm($this->id);
    }
    
    public function viewAction()
    {
        if (!$this->model) {
            throw new RuntimeException('No model was set for CrudController::viewAction');
        }
        
        $admin = $this->getAdminManager();
        $model = $this->model;
        
        return array(
            'definition' => $admin->getDefinition($model),
            'data'       => $admin->getViewData($model),
            'model'      => $model
        );
    }
}
