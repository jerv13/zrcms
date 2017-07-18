<?php

namespace Zrcms\CoreConfigDataSource\Block\Model;

use Zrcms\Content\Model\TrackableProperties;
use Zrcms\Core\Block\Model\BlockProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BlockConfigFields
{
    const NAME = BlockProperties::NAME;
    const DIRECTORY = BlockProperties::DIRECTORY;
    const CATEGORY = BlockProperties::CATEGORY;
    const LABEL = BlockProperties::LABEL;
    const DESCRIPTION = BlockProperties::DESCRIPTION;
    const RENDERER = BlockProperties::RENDERER;
    const DATA_PROVIDER = BlockProperties::DATA_PROVIDER;
    const ICON = BlockProperties::ICON;
    const EDITOR = BlockProperties::EDITOR;
    const CACHEABLE = BlockProperties::CACHEABLE;
    const FIELDS = BlockProperties::FIELDS;
    const DEFAULT_CONFIG = BlockProperties::DEFAULT_CONFIG;
    const CREATED_BY_USER_ID = TrackableProperties::CREATED_BY_USER_ID;
    const CREATED_REASON = TrackableProperties::CREATED_REASON;
}
