<?php

namespace SpiffyAdmin\Mapper;

use Zend\Stdlib\Options;

class DoctrineDbalOptions extends Options
{
    /**
     * The table to work on.
     *
     * @var string
     */
    protected $table;

    /**
     * The identifying column or columns.
     *
     * @var array|string
     */
    protected $identifier = 'id';

    /**
     * @param string $table
     * @return DoctrineDbalOptions
     */
    public function setTable($table)
    {
        $this->table = $table;
        return $this;
    }

    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * @param array|string $identifier
     * @return DoctrineDbalOptions
     */
    public function setIdentifier($identifier)
    {
        $this->identifier = $identifier;
        return $this;
    }

    /**
     * @return array|string
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }
}