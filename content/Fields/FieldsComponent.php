<?php

namespace Zrcms\Content\Fields;

use Zrcms\Content\Model\ComponentBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsComponent extends FieldsAbstract implements Fields
{
    const COMPONENT_CONFIG_READER = 'componentConfigReader';
    const COMPONENT_CLASS = 'componentClass';

    /**
     * @var array
     */
    protected $defaultFieldsConfig
        = [
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
