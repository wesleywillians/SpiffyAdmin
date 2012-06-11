<?php

namespace SpiffyAdmin;

use InvalidArgumentException;
use SpiffyAdmin\Consumer\AbstractConsumer;
use SpiffyAdmin\Definition\AbstractDefinition;
use SpiffyAdmin\FormBuilder\AbstractFormBuilder;
use SpiffyAdmin\Provider\AbstractProvider;
use Zend\InputFilter\InputFilter;
use Zend\Form\Form;

class Manager
{
    /**
     * @var array
     */
    protected $definitions = array();

    /**
     * @var \SpiffyAdmin\FormBuilder\AbstractFormBuilder
     */
    protected $formBuilder;

    /**
     * @var \SpiffyAdmin\Provider\AbstractProvider
     */
    protected $provider;

    /**
     * @var \SpiffyAdmin\Consumer\AbstractConsumer
     */
    protected $consumer;

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
     * @param $name
     * @return \Zend\Form\Form
     */
    public function getForm($name)
    {
        return $this->formBuilder()->build($this->getDefinition($name));
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
     * @param \SpiffyAdmin\FormBuilder\AbstractFormBuilder $formBuilder
     * @return \SpiffyAdmin\Manager
     */
    public function setFormBuilder(AbstractFormBuilder $formBuilder)
    {
        $this->formBuilder = $formBuilder;
        return $this;
    }

    /**
     * @return \SpiffyAdmin\FormBuilder\AbstractFormBuilder
     */
    public function formBuilder()
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