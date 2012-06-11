<?php

namespace SpiffyAdmin\FormBuilder;

use Doctrine\Common\Persistence\ObjectManager;
use SpiffyAdmin\Definition\AbstractDefinition;
use Zend\InputFilter\InputFilter;
use Zend\Form\Form;

class DoctrineObject extends AbstractFormBuilder
{
    /**
     * @var \Doctrine\Common\Persistence\ObjectManager
     */
    protected $om;

    /**
     * @param \Doctrine\Common\Persistence\ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }

    public function getForm(AbstractDefinition $definition)
    {
        // todo: implement
    }

    public function getInputFilter(AbstractDefinition $definition)
    {
        // todo: implement
    }

    /**
     * @return \Doctrine\Common\Persistence\ObjectManager
     */
    public function om()
    {
        return $this->om;
    }
}