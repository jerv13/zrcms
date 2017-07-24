<?php

namespace Zrcms\ContentCoreConfigDataSource\Content\Model;

use Zrcms\Content\Model\PropertiesComponent;
use Zrcms\Content\Model\TrackableProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ComponentConfigFields extends PropertiesComponent
{
    const CREATED_BY_USER_ID = TrackableProperties::CREATED_BY_USER_ID;
    const CREATED_REASON = TrackableProperties::CREATED_REASON;

    const COMPONENT_CONFIG_READER = 'component-config-reader';
}
