<?php

namespace SpiffyAdmin;

use InvalidArgumentException;
use SpiffyAdmin\Consumer\AbstractConsumer;
use SpiffyAdmin\Definition\AbstractDefinition;
use SpiffyAdmin\Provider\AbstractProvider;
use Zend\InputFilter\InputFilter;
use Zend\Form\Annotation\AnnotationBuilder;
use Zend\Form\Form;

class Manager
{
    /**
     * @var array
     */
    protected $definitions = array();

    /**
     * @var \Zend\Form\Annotation\AnnotationBuilder
     */
    protected $formBuilder;

    /**
     * @var \SpiffyAdmin\Provider\AbstractProvider
     */
    protected $provider;

    /**
     * @var \SpiffyAdmin\Service\ManagerOptions
     */
    protected $options;

    /**
     * @var \SpiffyAdmin\Consumer\AbstractConsumer
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
     * @return \SpiffyAdmin\Manager
     */
    public function addDefinition(AbstractDefinition $definition)
    {
        $this->definitions[$definition->getCanonicalName()] = $definition;
        return $this;
    }

    /**
     * @param string $name
     * @param object $entity
     * @return \Zend\Form\Form
     */
    public function getForm($name, $entity = null)
    {
        $builder     = $this->getFormBuilder();
        $definition  = $this->getDefinition($name);
        $entityClass = $definition->options()->getEntityClass();

        if (null === $entity) {
            $entity = new $entityClass;
        }

        if (get_class($entity) !== $entityClass) {
            throw new InvalidArgumentException(sprintf(
                'Entity class "%s" expected, received "%s"',
                $entityClass,
                get_class($entity)
            ));
        }

        $form = $builder->createForm($entity);

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
     * @param \SpiffyAdmin\Provider\AbstractProvider $ds
     * @return \SpiffyAdmin\Manager
     */
    public function setProvider(AbstractProvider $provider)
    {
        $this->provider = $provider;
        return $this;
    }

    /**
     * @return \SpiffyAdmin\Provider\AbstractProvider
     */
    public function provider()
    {
        return $this->provider;
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
        if (!$this->consumer->provider()) {
            $this->consumer->setProvider($this->provider());
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