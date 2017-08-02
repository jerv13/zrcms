<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Block\Model;

use Zrcms\Content\Model\TrackableProperties;
use Zrcms\ContentCore\Block\Model\PropertiesBlockVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesBlockVersionEntity extends PropertiesBlockVersion
{
    const CREATED_BY_USER_ID = TrackableProperties::CREATED_BY_USER_ID;
    const CREATED_REASON = TrackableProperties::CREATED_REASON;
    const CREATED_DATE = TrackableProperties::CREATED_DATE;

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
            self::BLOCK_CONTAINER_CMS_RESOURCE_ID => '',
            self::CREATED_BY_USER_ID => '',
            self::CREATED_REASON => '',
            self::CREATED_DATE => '',
        ];
}
