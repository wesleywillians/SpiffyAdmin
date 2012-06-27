<?php

namespace SpiffyAdmin\Mapper;

use InvalidArgumentException;
use Doctrine\DBAL\Connection;
use SpiffyAdmin\Definition\AbstractDefinition;

class DoctrineDbal extends AbstractMapper
{
    /**
     * @var Connection
     */
    protected $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
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
        $hydrator = $def->options()->getHydrator();
        $builder  = $this->getQueryBuilder($def);

        return $builder->execute();
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

    protected function getQueryBuilder(AbstractDefinition $def)
    {
        $options = $this->options($def);
        if (!$options->getTable()) {
            throw new InvalidArgumentException('Missing mapper option: table');
        }
        if (!$options->getIdentifier()) {
            throw new InvalidArgumentException('Missing mapper option: identifier');
        }
        $qb = $this->connection->createQueryBuilder();
        $qb->select('*');
        $qb->from($options->getTable(), 'q');

        return $qb;
    }

    /**
     * @param AbstractDefinition $def
     * @return ZendDbOptions
     */
    protected function options(AbstractDefinition $def)
    {
        return new DoctrineDbalOptions($def->options()->getMapperOptions());
    }
}