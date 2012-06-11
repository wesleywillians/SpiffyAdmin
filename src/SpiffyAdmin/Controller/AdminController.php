<?php

namespace SpiffyAdmin\Controller;

use SpiffyAdmin\Module as SpiffyAdmin;
use Zend\Mvc\Controller\ActionController;

class AdminController extends ActionController
{
    public function indexAction()
    {
        return array('definitions' => $this->manager()->getDefinitions());
    }
    
    public function addAction()
    {
        $match   = $this->getEvent()->getRouteMatch();
        $name    = $match->getParam('name');
        $request = $this->getRequest();
        $form    = $this->manager()->getForm($name);
        $def     = $this->manager()->getDefinition($name);
        $model   = $def->options()->getModel();

        $form->bind(new $model);

        if ($request->isPost()) {
            $form->setData($request->post());

            if ($form->isValid()) {
                $this->manager()->provider()->create($form->getData());
                return $this->redirect()->toRoute('spiffyadmin/view', array('name' => $def->getName()));
            }
        }

        return array(
            'definition' => $def,
            'form'       => $form
        );
    }

    public function editAction()
    {
        $match   = $this->getEvent()->getRouteMatch();
        $name    = $match->getParam('name');
        $id      = $match->getParam('id');
        $request = $this->getRequest();
        $form    = $this->manager()->getForm($name);
        $def     = $this->manager()->getDefinition($name);
        $model   = $def->options()->getModel();

        $form->bind($this->manager()->provider()->find($model, $id));

        if ($request->isPost()) {
            $form->setData($request->post());

            if ($form->isValid()) {
                $this->manager()->provider()->create($form->getData());
                return $this->redirect()->toRoute('spiffyadmin/view', array('name' => $def->getName()));
            }
        }

        return array(
            'definition' => $def,
            'form'       => $form
        );
    }

    public function deleteAction()
    {
        $match   = $this->getEvent()->getRouteMatch();
        $def     = $this->manager()->getDefinition($match->getParam('name'));
        $model   = $def->options()->getModel();

        $this->manager()->provider()->delete($this->manager()->provider()->find($model, $match->getParam('id')));
        return $this->redirect()->toRoute('spiffyadmin/view', array('name' => $def->getName()));
    }
    
    public function viewAction()
    {
        $name = $this->getEvent()->getRouteMatch()->getParam('name');
        $def  = $this->manager()->getDefinition($name);

        return array(
            'dName'  => $def->getDisplayName(),
            'cName'  => $def->getCanonicalName(),
            'source' => $this->manager()->consumer()->getOutput($def)
        );
    }

    /**
     * @return \SpiffyAdmin\Manager
     */
    protected function manager()
    {
        return $this->getServiceLocator()->get('SpiffyAdmin\Manager');
    }
}