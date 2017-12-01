<?php

namespace Zrcms\Content\Fields;

use Zrcms\Content\Model\ComponentBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsComponentRegistry extends FieldsAbstract implements Fields
{
    const NAME = FieldsComponentConfig::NAME;
    const CONFIG_LOCATION = FieldsComponentConfig::CONFIG_LOCATION;
    const COMPONENT_CONFIG_READER = FieldsComponent::COMPONENT_CONFIG_READER;
    const COMPONENT_CLASS = FieldsComponent::COMPONENT_CLASS;

    /**
     * @var array
     */
    protected $defaultFieldsConfig
        = [
            [
                'name' => self::NAME,
                'type' => 'text',
                'label' => 'Name',
                'required' => true,
                'default' => '',
                'options' => [],
            ],
            [
                'name' => self::CONFIG_LOCATION,
                'type' => 'text',
                'label' => 'Config Location (usually a path or application config key)',
                'required' => true,
                'default' => '',
                'options' => [],
            ],
            [
                'name' => self::COMPONENT_CONFIG_READER,
                'type' => 'zrcms-service',
                'label' => 'Component Config Reader',
                'required' => false,
                'default' => 'json',
                'options' => [],
            ],
            [
                'name' => self::COMPONENT_CLASS,
                'type' => 'class',
                'label' => 'Component Class',
                'required' => false,
                'default' => ComponentBasic::class,
                'options' => [],
            ],
        ];
}
