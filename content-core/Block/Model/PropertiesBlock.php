<?php

namespace Zrcms\ContentCore\Block\Model;

use Zrcms\Content\Model\PropertiesContent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesBlock extends PropertiesContent
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
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::ID => '',
            self::CONTAINER_VERSION_ID => '',
            self::BLOCK_COMPONENT_NAME => '',
            self::CONFIG => [],
            self::LAYOUT_PROPERTIES => [
                self::LAYOUT_PROPERTIES_RENDER_ORDER => 0,
                self::LAYOUT_PROPERTIES_ROW_NUMBER => 0,
                self::LAYOUT_PROPERTIES_COLUMN_CLASS => '',
            ],
        ];
}
