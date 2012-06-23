<?php

namespace SpiffyAdmin;

use InvalidArgumentException;
use SpiffyAdmin\Consumer\AbstractConsumer;
use SpiffyAdmin\Definition\AbstractDefinition;
use SpiffyAdmin\Mapper\AbstractMapper;
use Zend\InputFilter\InputFilter;
use Zend\Form\Annotation\AnnotationBuilder;

class Manager
{
    /**
     * @var array
     */
    protected $definitions = array();

    /**
     * @var AnnotationBuilder
     */
    protected $formBuilder;

    /**
     * @var AbstractMapper
     */
    protected $mapper;

    /**
     * @var \SpiffyAdmin\Service\ManagerOptions
     */
    protected $options;

    /**
     * @var AbstractConsumer
     */
    protected $consumer;

    public function __construct(array $options = array())
    {
        $this->options = new Service\ManagerOptions($options);
    }

    /**
     * @return Service\ManagerOptions
     */
    public function options()
    {
        return $this->options;
    }

    /**
     * @param AbstractDefinition $definition
     * @return Manager
     */
    public function addDefinition(AbstractDefinition $definition)
    {
        $this->definitions[$definition->getCanonicalName()] = $definition;
        return $this;
    }

    /**
     * @param string $name
     * @param object $input
     * @return \Zend\Form\Form
     */
    public function getForm($name, $input = null)
    {
        $builder     = $this->getFormBuilder();
        $definition  = $this->getDefinition($name);
        $entityClass = $definition->options()->getEntityClass();

        if (null === $input) {
            $input = new $entityClass;
        }

        if (get_class($input) !== $entityClass) {
            throw new InvalidArgumentException(sprintf(
                'Entity class "%s" expected, received "%s"',
                $entityClass,
                get_class($input)
            ));
        }

        $form = $builder->createForm($entityClass);

        if ($hydrator = $definition->options()->getHydrator()) {
            $form->setHydrator($hydrator);
        }

        $form->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit'
            )
        ));

        return $form;
    }

    /**
     * @param \SpiffyAdmin\Mapper\AbstractMapper $ds
     * @return \SpiffyAdmin\Manager
     */
    public function setMapper(AbstractMapper $mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }

    /**
     * @return \SpiffyAdmin\Mapper\AbstractMapper
     */
    public function mapper()
    {
        return $this->mapper;
    }

    /**
     * @param \SpiffyAdmin\Consumer\AbstractConsumer $consumer
     * @return \SpiffyAdmin\Manager
     */
    public function setConsumer(AbstractConsumer $consumer)
    {
        $this->consumer = $consumer;
        return $this;
    }

    /**
     * @return \SpiffyAdmin\Consumer\AbstractConsumer
     */
    public function consumer()
    {
        if (!$this->consumer->mapper()) {
            $this->consumer->setMapper($this->mapper());
        }
        return $this->consumer;
    }

    /**
     * Set the form builder.
     *
     * @param \Zend\Form\Annotation\AnnotationBuilder $formBuilder
     * @return \SpiffyAdmin\Manager
     */
    public function setFormBuilder(AnnotationBuilder $formBuilder)
    {
        $this->formBuilder = $formBuilder;
        return $this;
    }

    /**
     * Get the form builder.
     *
     * @return \Zend\Form\Annotation\AnnotationBuilder
     */
    public function getFormBuilder()
    {
        return $this->formBuilder;
    }

    /**
     * @return array
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }

    /**
     * @param $name
     * @return \SpiffyAdmin\Definition\AbstractDefinition
     * @throws \InvalidArgumentException
     */
    public function getDefinition($name)
    {
        if (!isset($this->definitions[$name])) {
            throw new InvalidArgumentException(sprintf(
                'No definition with name "%s" could be found.',
                $name
            ));
        }
        return $this->definitions[$name];
    }
}