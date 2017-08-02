<?php

namespace Zrcms\ContentCoreConfigDataSource\Content\Model;

use Zrcms\Content\Model\PropertiesComponent;
use Zrcms\Content\Model\TrackableProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ComponentConfigFields extends PropertiesComponent
{
    const CREATED_BY_USER_ID = TrackableProperties::CREATED_BY_USER_ID;
    const CREATED_REASON = TrackableProperties::CREATED_REASON;

    const COMPONENT_CONFIG_READER = 'component-config-reader';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::NAME => '',
            self::LOCATION => '',
            self::CREATED_BY_USER_ID => '',
            self::CREATED_REASON => '',
            self::COMPONENT_CONFIG_READER => '',
        ];
}
