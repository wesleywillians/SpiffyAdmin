<?php

namespace SpiffyAdmin\Consumer;

use InvalidArgumentException;
use SpiffyAdmin\Definition\AbstractDefinition;
use SpiffyDataTables\Source\Source;

class DataTablesConsumer extends AbstractConsumer
{
    public function getOutput(AbstractDefinition $def)
    {
        $options = $def->options()->getConsumerOptions();
        $data    = $this->provider()->findAll($def);
        $source  = new Source($data);

        if (!isset($options['columns']) || empty($options['columns'])) {
            throw new InvalidArgumentException('DataTables consumer can not work without columns');
        }

        // standard tables
        foreach($options['columns'] as $name => $attributes) {
            if (is_int($name)) {
                $attributes = array('name' => $attributes);
            } else {
                $attributes['name'] = $name;
            }

            $source->addColumn($attributes);
        }

        return $source;
    }
}