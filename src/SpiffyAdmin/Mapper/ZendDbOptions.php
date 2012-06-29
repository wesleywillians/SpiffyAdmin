<?php

namespace SpiffyAdmin\Mapper;

use Zend\Stdlib\AbstractOptions;

class ZendDbOptions extends AbstractOptions
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
     * @return ZendDbOptions
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
     * @return ZendDbOptions
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