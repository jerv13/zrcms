<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Block\Model;

use Zrcms\Content\Model\TrackableProperties;
use Zrcms\ContentCore\Block\Model\PropertiesBlockVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PropertiesBlockVersionEntity extends PropertiesBlockVersion
{
    const CREATED_BY_USER_ID = TrackableProperties::CREATED_BY_USER_ID;
    const CREATED_REASON = TrackableProperties::CREATED_REASON;
    const CREATED_DATE = 'createdDate';
}
