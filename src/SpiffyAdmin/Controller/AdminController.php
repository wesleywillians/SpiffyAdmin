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
        $request = $this->getRequest();
        $form    = $this->manager()->getForm($this->params('name'));
        $def     = $this->manager()->getDefinition($this->params('name'));
        $entity  = $def->getFormClass();

        $form->bind(new $entity);

        if ($request->isPost()) {
            $form->setData($request->post());

            if ($form->isValid()) {
                $this->manager()->mapper()->create($def, $form->getData());
                return $this->redirect()->toRoute('spiffyadmin/view', array('name' => $def->getCanonicalName()));
            }
        }

        return array(
            'definition' => $def,
            'form'       => $form
        );
    }

    public function editAction()
    {
        $request = $this->getRequest();
        $form    = $this->manager()->getForm($this->params('name'));
        $def     = $this->manager()->getDefinition($this->params('name'));
        $entity  = $this->manager()->mapper()->find($def, $this->params('id'));

        $form->bind($entity);

        if ($request->isPost()) {
            $form->setData($request->post());

            if ($form->isValid()) {
                $this->manager()->mapper()->update($def, $form->getData(), $this->params('id'));
                return $this->redirect()->toRoute('spiffyadmin/view', array('name' => $def->getCanonicalName()));
            }
        }

        return array(
            'definition' => $def,
            'form'       => $form
        );
    }

    public function deleteAction()
    {
        $match  = $this->getEvent()->getRouteMatch();
        $def    = $this->manager()->getDefinition($match->getParam('name'));

        $this->manager()->mapper()->delete($def, $this->params('id'));
        return $this->redirect()->toRoute('spiffyadmin/view', array('name' => $def->getCanonicalName()));
    }
    
    public function viewAction()
    {
        $def  = $this->manager()->getDefinition($this->params('name'));

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