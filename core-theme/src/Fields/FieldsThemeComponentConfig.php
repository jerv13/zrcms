<?php

namespace Zrcms\CoreTheme\Fields;

use Zrcms\Core\Fields\FieldsComponentConfig;
use Zrcms\Core\Model\Trackable;
use Zrcms\CoreTheme\Model\ThemeComponentBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsThemeComponentConfig extends FieldsComponentConfig
{
    const PRIMARY_LAYOUT = FieldsThemeComponent::PRIMARY_LAYOUT_NAME;

    const DEFAULT_PRIMARY_LAYOUT_NAME = FieldsThemeComponent::DEFAULT_PRIMARY_LAYOUT_NAME;

    /**
     * @var array
     */
    protected $defaultFieldsConfig
        = [
            [
                'name' => self::TYPE,
                'type' => 'text',
                'label' => 'Component Type',
                'required' => true,
                'default' => '',
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
                'name' => self::CREATED_BY_USER_ID,
                'type' => 'zrcms-service',
                'label' => 'Created By User ID',
                'required' => false,
                'default' => Trackable::UNKNOWN_USER_ID,
                'options' => [],
            ],
            [
                'name' => self::CREATED_REASON,
                'type' => 'class',
                'label' => 'Component Class',
                'required' => false,
                'default' => Trackable::UNKNOWN_REASON,
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
                'default' => ThemeComponentBasic::class,
                'options' => [],
            ],
            [
                'name' => self::PRIMARY_LAYOUT,
                'type' => 'text',
                'label' => 'Primary Layout Name',
                'required' => true,
                'default' => self::DEFAULT_PRIMARY_LAYOUT_NAME,
                'options' => [],
            ],
        ];
}
