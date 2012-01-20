<?php

namespace SpiffyAdmin\Mapper;

use SpiffyAdmin\Admin\Definition;

interface MapperInterface
{
    public function getViewData(Definition $def);
    
    public function getFormBuilder(Definition $def);
    
    public function findById(Definition $def, $id);
    
    public function save(Definition $def, $object);
}