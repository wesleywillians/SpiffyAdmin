<?php

namespace SpiffyAdmin\Mapper;

use SpiffyAdmin\Definition\AbstractDefinition;

abstract class AbstractMapper
{
    abstract public function find(AbstractDefinition $def, $id);

    abstract public function findAll(AbstractDefinition $name);

    abstract public function create(AbstractDefinition $def, $entity);

    abstract public function update(AbstractDefinition $def, $entity, $identifier);

    abstract public function delete(AbstractDefinition $def, $identifier);
}