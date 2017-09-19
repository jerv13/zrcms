<?php

namespace Zrcms\ContentCore\Theme\Fields;

use Zrcms\Content\Fields\FieldsComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsThemeComponent extends FieldsComponent
{
    const PRIMARY_LAYOUT_NAME = 'primaryLayoutName';
    const LAYOUT_VARIATIONS = 'layoutVariations';

    /**
     * @var array
     */
    protected $defaultFieldsConfig
        = [
            [
                'name' => self::PRIMARY_LAYOUT_NAME,
                'type' => 'text',
                'label' => 'Primary Layout Name',
                'required' => true,
                'default' => 'primary',
                'options' => [],
            ],
            [
                'name' => self::LAYOUT_VARIATIONS,
                'type' => 'array',
                'label' => 'Layout Variation Locations',
                'required' => true,
                'default' => [],
                'options' => [],
            ],
        ];
}
