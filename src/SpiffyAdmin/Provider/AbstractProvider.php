<?php

namespace SpiffyAdmin\Provider;

use SpiffyAdmin\Definition\AbstractDefinition;

abstract class AbstractProvider
{
    abstract public function find($modelName, $id);

    abstract public function findAll(AbstractDefinition $name);

    abstract public function create($model);

    abstract public function update($model);

    abstract public function delete($model);
}