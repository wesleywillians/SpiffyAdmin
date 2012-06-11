<?php

namespace SpiffyAdmin\FormBuilder;

use InvalidArgumentException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use DoctrineORMModule\Form\Element\DoctrineEntity as DoctrineEntityElement;
use SpiffyAdmin\Definition\AbstractDefinition;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class DoctrineEntity extends DoctrineObject
{
    protected $typeMap = array(
        'string'   => 'text',
        'integer'  => 'text',
        'smallint' => 'text',
        'bigint'   => 'text',
        'boolean'  => 'checkbox',
        'decimal'  => 'text',
        'date'     => 'text',
        'time'     => 'text',
        'datetime' => 'text',
        'text'     => 'textarea',
    );

    public function getForm(AbstractDefinition $definition)
    {
        /** @var $metadata \Doctrine\ORM\Mapping\ClassMetadata */
        $metadata = $this->om()->getClassMetadata($definition->options()->getModel());
        $formData = $definition->options()->getFormOptions();
        $form     = new Form;

        foreach($formData['elements'] as $field => $attributes) {
            if (is_int($field)) {
                $field      = $attributes;
                $attributes = array();
            }
            $detected = array();

            if ($metadata->hasField($field)) {
                $fdata            = $metadata->getFieldMapping($field);
                $detected['type'] = $fdata['type'];
            } else if ($metadata->hasAssociation($field)) {
                $fdata = $metadata->getAssociationMapping($field);

                if ($fdata['type'] & ClassMetadataInfo::TO_ONE) {
                    $element = new DoctrineEntityElement($field);
                    $element->setEntityManager($this->om());
                    $element->setTargetClass($metadata->getAssociationTargetClass($field));

                    $detected['type'] = get_class($element);

                    $form->add($element);
                    continue;
                } else if ($fdata['type'] & ClassMetadataInfo::TO_MANY) {
                    // todo: implement
                } else {
                    throw new InvalidArgumentException('unexpected input');
                }
            } else {
                $fdata = array();
            }

            $detected['required'] = !(isset($fdata['nullable']) && $fdata['nullable']);

            $attributes = array_merge($detected, $attributes);

            $form->add(array(
                'name'       => $field,
                'attributes' => $attributes
            ));
        }

        $form->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit'
            )
        ));

        return $form;
    }

    public function getInputFilter(AbstractDefinition $definition)
    {
        /** @var $metadata \Doctrine\ORM\Mapping\ClassMetadata */
        $metadata = $this->om()->getClassMetadata($definition->options()->getModel());
        $formData = $definition->options()->getFormOptions();
        $filter   = new InputFilter;

        foreach($formData['elements'] as $field => $attributes) {
            if (is_int($field)) {
                $field      = $attributes;
                $attributes = array();
            }

            $filter->add(array(
                'name' => $field,
            ));
        }
        return $filter;
    }
}