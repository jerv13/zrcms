<?php

namespace Zrcms\ContentCore\Block\Fields;

use Zrcms\Content\Fields\FieldsContent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsBlock extends FieldsContent
{
    // required
    const CONTAINER_VERSION_ID = 'containerVersionId';
    const BLOCK_COMPONENT_NAME = 'blockComponentName';
    const CONFIG = 'config';

    // client layout required
    const LAYOUT_PROPERTIES = 'layoutProperties';
    const LAYOUT_PROPERTIES_RENDER_ORDER = 'renderOrder';
    const LAYOUT_PROPERTIES_ROW_NUMBER = 'rowNumber';
    const LAYOUT_PROPERTIES_COLUMN_CLASS = 'columnClass';

    // render data properties
    const RENDER_DATA_ID = 'id';
    const RENDER_DATA_CONFIG = 'config';
    const RENDER_DATA_DATA = 'data';

    /**
     * @var array
     */
    protected $defaultFieldsConfig
        = [
            [
                'name' => self::CONTAINER_VERSION_ID,
                'type' => 'string',
                'label' => 'Container Version Id',
                'required' => true,
                'default' => '',
                'options' => [],
            ],
            [
                'name' => self::BLOCK_COMPONENT_NAME,
                'type' => 'string',
                'label' => 'Block Component Name',
                'required' => true,
                'default' => '',
                'options' => [],
            ],
            [
                'name' => self::CONFIG,
                'type' => 'array',
                'label' => 'Config',
                'required' => false,
                'default' => [],
                'options' => [],
            ],
            [
                'name' => self::LAYOUT_PROPERTIES,
                'type' => 'fields',
                'label' => 'Layout Properties',
                'required' => true,
                'default' => [],
                'options' => [
                    'fields' => [
                        [
                            'name' => self::LAYOUT_PROPERTIES_RENDER_ORDER,
                            'type' => 'int',
                            'label' => 'Render Order',
                            'required' => true,
                            'default' => 0,
                            'options' => [],
                        ],
                        [
                            'name' => self::LAYOUT_PROPERTIES_ROW_NUMBER,
                            'type' => 'int',
                            'label' => 'Row Number',
                            'required' => true,
                            'default' => 0,
                            'options' => [],
                        ],
                        [
                            'name' => self::LAYOUT_PROPERTIES_COLUMN_CLASS,
                            'type' => 'int',
                            'label' => 'Column CSS Class',
                            'required' => false,
                            'default' => '',
                            'options' => [],
                        ],
                    ]
                ],
            ],
        ];
}
