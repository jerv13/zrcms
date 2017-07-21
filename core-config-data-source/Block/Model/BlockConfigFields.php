<?php

namespace Zrcms\CoreConfigDataSource\Block\Model;

use Zrcms\Content\Model\TrackableProperties;
use Zrcms\Core\Block\Model\PropertiesBlockComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface BlockConfigFields extends PropertiesBlockComponent
{
    const CREATED_BY_USER_ID = TrackableProperties::CREATED_BY_USER_ID;
    const CREATED_REASON = TrackableProperties::CREATED_REASON;
}
