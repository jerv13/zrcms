<?php

namespace Zrcms\ContentCore\Theme\Fields;

use Zrcms\Content\Fields\FieldsComponentConfig;
use Zrcms\Content\Model\Trackable;
use Zrcms\ContentCore\Theme\Fields\FieldsThemeComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsThemeComponentConfig extends FieldsComponentConfig
{
    const PRIMARY_LAYOUT = FieldsThemeComponent::PRIMARY_LAYOUT_NAME;
    const LAYOUT_LOCATIONS = 'layoutLocations';

    /**
     * @var array
     */
    protected $defaultFieldsConfig
        = [
            [
                'name' => self::CATEGORY,
                'type' => 'text',
                'label' => 'Component Category',
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
                'default' => 'primary',
                'options' => [],
            ],
            [
                'name' => self::LAYOUT_LOCATIONS,
                'type' => 'array',
                'label' => 'Layout Variation Locations',
                'required' => true,
                'default' => [],
                'options' => [],
            ],
        ];
}
