<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Model;

use Zrcms\Content\Model\TrackableProperties;
use Zrcms\ContentCore\Block\Model\PropertiesBlockComponent;
use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentConfigFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface BlockComponentConfigFields extends ComponentConfigFields, PropertiesBlockComponent
{
    const CREATED_BY_USER_ID = TrackableProperties::CREATED_BY_USER_ID;
    const CREATED_REASON = TrackableProperties::CREATED_REASON;
}
