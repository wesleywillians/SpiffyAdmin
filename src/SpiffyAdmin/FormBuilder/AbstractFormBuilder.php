<?php

namespace SpiffyAdmin\FormBuilder;

use SpiffyAdmin\Definition\AbstractDefinition;

abstract class AbstractFormBuilder
{
    /**
     * @var \Zend\Stdlib\Hydrator\HydratorInterface
     */
    protected $hydrator;

    public function build(AbstractDefinition $definition)
    {
        $form        = $this->getForm($definition);
        $hydrator    = $this->getHydrator();
        $inputFilter = $this->getInputFilter($definition);

        $form->setInputFilter($inputFilter);
        $form->setHydrator($hydrator);

        return $form;
    }

    /**
     * @return \Zend\Stdlib\Hydrator\ClassMethods
     */
    public function getHydrator()
    {
        return new \Zend\Stdlib\Hydrator\ClassMethods;
    }

    abstract public function getForm(AbstractDefinition $definition);

    abstract public function getInputFilter(AbstractDefinition $definition);
}