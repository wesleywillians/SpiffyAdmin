<?php

namespace SpiffyAdmin\Mapper;

use InvalidArgumentException;
use SpiffyAdmin\Definition\AbstractDefinition;
use Zend\Db\Adapter\Adapter;
use Zend\Db\TableGateway\TableGateway;

class ZendDb extends AbstractMapper
{
    /**
     * @var \Zend\Db\Adapter\Adapter
     */
    protected $adapter;

    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    public function find(AbstractDefinition $def, $id)
    {
        $hydrator    = $def->options()->getHydrator();
        $gateway     = $this->getTableGateway($def);
        $result      = $gateway->select(array('id' => $id));
        $entityClass = $def->options()->getEntityClass();

        return $hydrator->hydrate(array_shift($result->toArray()), new $entityClass);
    }

    public function findAll(AbstractDefinition $def)
    {
        return $this->getTableGateway($def)->select()->toArray();
    }

    public function create(AbstractDefinition $def, $entity)
    {
        $hydrator = $def->options()->getHydrator();
        $gateway  = $this->getTableGateway($def);
        $gateway->insert($hydrator->extract($entity));
    }

    public function update(AbstractDefinition $def, $entity, $identifier)
    {
        $hydrator    = $def->options()->getHydrator();
        $gateway     = $this->getTableGateway($def);
        $gateway->update($hydrator->extract($entity), array($this->options($def)->getIdentifier() => $identifier));
    }

    public function delete(AbstractDefinition $def, $identifier)
    {
        $gateway = $this->getTableGateway($def);
        $gateway->delete(array($this->options($def)->getIdentifier() => $identifier));
    }

    protected function getTableGateway(AbstractDefinition $def)
    {
        $options = $this->options($def);
        if (!$options->getTable()) {
            throw new InvalidArgumentException('Missing mapper option: table');
        }
        if (!$options->getIdentifier()) {
            throw new InvalidArgumentException('Missing mapper option: identifier');
        }
        return new TableGateway($options->getTable(), $this->adapter);
    }

    /**
     * @param AbstractDefinition $def
     * @return ZendDbOptions
     */
    protected function options(AbstractDefinition $def)
    {
        return new ZendDbOptions($def->options()->getMapperOptions());
    }
}