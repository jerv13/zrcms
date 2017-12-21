<?php

namespace Zrcms\Core\Fields;

use Zrcms\Core\Model\ComponentBasic;
use Zrcms\Fields\Model\Fields;
use Zrcms\Fields\Model\FieldsAbstract;

/**
 * @deprecated
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsComponentRegistry extends FieldsAbstract implements Fields
{
    const TYPE = FieldsComponentConfig::TYPE;
    const NAME = FieldsComponentConfig::NAME;
    const CONFIG_URI = FieldsComponentConfig::CONFIG_URI;
    const MODULE_DIRECTORY = FieldsComponentConfig::MODULE_DIRECTORY;
    const COMPONENT_CONFIG_READER = FieldsComponent::COMPONENT_CONFIG_READER;
    const COMPONENT_CLASS = FieldsComponent::COMPONENT_CLASS;

    const DEFAULT_TYPE = FieldsComponentConfig::DEFAULT_TYPE;

    /**
     * @var array
     */
    protected $defaultFieldsConfig
        = [
            [
                'name' => self::TYPE,
                'type' => 'text',
                'label' => 'Component Type',
                'required' => true, // NOTE: this may not be required as we can use default
                'default' => self::DEFAULT_TYPE,
                'options' => [],
            ],
            [
                'name' => self::NAME,
                'type' => 'text',
                'label' => 'Name',
                'required' => true,
                'default' => '',
                'options' => [],
            ],
            [
                'name' => self::CONFIG_URI,
                'type' => 'text',
                'label' => 'Config Location (usually a file path or application config key)',
                'required' => true,
                'default' => '',
                'options' => [],
            ],
            [
                'name' => self::MODULE_DIRECTORY,
                'type' => 'text',
                'label' => 'Module Directory (module directory for component files)',
                'required' => false,
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
