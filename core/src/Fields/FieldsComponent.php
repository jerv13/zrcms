<?php

namespace Zrcms\Core\Fields;

use Zrcms\Core\Model\ComponentBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsComponent extends FieldsAbstract implements Fields
{
    const COMPONENT_CONFIG_READER = 'componentConfigReader';
    const COMPONENT_CLASS = 'componentClass';
    const JAVASCRIPT = 'js';
    const CSS = 'css';

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
            [
                'name' => self::JAVASCRIPT,
                'type' => 'array',
                'label' => 'Javascript includes',
                'required' => false,
                'default' => [],
                'options' => [],
            ],
            [
                'name' => self::CSS,
                'type' => 'array',
                'label' => 'CSS Includes',
                'required' => false,
                'default' => [],
                'options' => [],
            ],
        ];
}
