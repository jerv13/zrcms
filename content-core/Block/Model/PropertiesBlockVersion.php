<?php

namespace Zrcms\ContentCore\Block\Model;

use Zrcms\Content\Model\PropertiesContentVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesBlockVersion extends PropertiesBlock
{
    // NOT USED const BLOCK_CONTAINER_CMS_RESOURCE_ID = 'blockContainerCmsResourceId';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            PropertiesContentVersion::ID => '',
            self::CONTAINER_VERSION_ID => '',
            self::BLOCK_COMPONENT_NAME => '',
            self::CONFIG => [],
            self::LAYOUT_PROPERTIES => [
                self::LAYOUT_PROPERTIES_RENDER_ORDER => 0,
                self::LAYOUT_PROPERTIES_ROW_NUMBER => 0,
                self::LAYOUT_PROPERTIES_COLUMN_CLASS => '',
            ],
            // NOT REQUIRED self::BLOCK_CONTAINER_CMS_RESOURCE_ID => '',
        ];
}
