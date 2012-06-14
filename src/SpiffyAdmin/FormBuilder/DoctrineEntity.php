<?php

namespace SpiffyAdmin\FormBuilder;

use InvalidArgumentException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\ClassMetadataInfo;
use DoctrineORMModule\Hydrator\DoctrineEntity as Hydrator;
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

    /**
     * @return \DoctrineORMModule\Hydrator\DoctrineEntity
     */
    public function getHydrator()
    {
        return new Hydrator($this->om());
    }

    public function getForm(AbstractDefinition $definition)
    {
        /** @var $metadata \Doctrine\ORM\Mapping\ClassMetadata */
        $metadata = $this->om()->getClassMetadata($definition->options()->getModel());
        $formData = $definition->options()->getFormOptions();
        $form     = new Form;

        if (!isset($formData['elements'])) {
            throw new InvalidArgumentException('DoctrineEntity builder needs elements to work on');
        }

        foreach($formData['elements'] as $field => $attributes) {
            if (is_int($field)) {
                $field      = $attributes;
                $attributes = array();
            }

            $detected = array();

            $type = 'string';
            if ($metadata->hasField($field)) {
                $fdata = $metadata->getFieldMapping($field);
                $type  = $fdata['type'];
            } else if ($metadata->hasAssociation($field)) {
                $fdata = $metadata->getAssociationMapping($field);

                $element = new DoctrineEntityElement($field);
                $element->setEntityManager($this->om());
                $element->setTargetClass($metadata->getAssociationTargetClass($field));

                if ($fdata['type'] & ClassMetadataInfo::TO_ONE) {

                } else if ($fdata['type'] & ClassMetadataInfo::TO_MANY) {
                    // todo: implement
                } else {
                    throw new InvalidArgumentException('unexpected input');
                }

                $element->setAttributes($attributes);
                $form->add($element);

                continue;
            } else {
                $fdata = array();
            }

            $detected['type']     = isset($this->typeMap[$type]) ? $this->typeMap[$type] : 'text';
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