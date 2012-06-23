<?php

namespace SpiffyAdmin\Service;

use Zend\Stdlib\Options;

class ManagerOptions extends Options
{
    /**
     * The name of the consumer to instantiate or pull from the
     * service manager.
     *
     * @var string
     */
    protected $consumer = 'SpiffyAdmin\Consumer\DataTablesConsumer';

    /**
     * The name of the mapper to instantiate or pull from the
     * service manager.
     *
     * @var string
     */
    protected $mapper = 'SpiffyAdmin\Mapper\ZendDb';

    /**
     * The name of the form builder to instantiate or pull from the
     * service manager.
     *
     * @var string
     */
    protected $formBuilder = 'Zend\Form\Annotation\AnnotationBuilder';

    /**
     * An array of definitions to use.
     *
     * @var array
     */
    protected $definitions = array();


    /**
     * @param string $consumer
     * @return ManagerOptions
     */
    public function setConsumer($consumer)
    {
        $this->consumer = $consumer;
        return $this;
    }

    /**
     * @return string
     */
    public function getConsumer()
    {
        return $this->consumer;
    }

    /**
     * @param array $definitions
     * @return ManagerOptions
     */
    public function setDefinitions($definitions)
    {
        $this->definitions = $definitions;
        return $this;
    }

    /**
     * @return array
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }

    /**
     * @param string $formBuilder
     * @return ManagerOptions
     */
    public function setFormBuilder($formBuilder)
    {
        $this->formBuilder = $formBuilder;
        return $this;
    }

    /**
     * @return string
     */
    public function getFormBuilder()
    {
        return $this->formBuilder;
    }

    /**
     * @param string $mapper
     * @return ManagerOptions
     */
    public function setMapper($mapper)
    {
        $this->mapper = $mapper;
        return $this;
    }

    /**
     * @return string
     */
    public function getMapper()
    {
        return $this->mapper;
    }
}