<?php

namespace Zrcms\CoreConfigDataSource\Block\Model;

use Zrcms\Content\Model\TrackableProperties;
use Zrcms\Core\Block\Model\PropertiesBlock;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BlockConfigFields
{
    const NAME = PropertiesBlock::NAME;
    const DIRECTORY = PropertiesBlock::DIRECTORY;
    const CATEGORY = PropertiesBlock::CATEGORY;
    const LABEL = PropertiesBlock::LABEL;
    const DESCRIPTION = PropertiesBlock::DESCRIPTION;
    const RENDERER = PropertiesBlock::RENDERER;
    const DATA_PROVIDER = PropertiesBlock::DATA_PROVIDER;
    const ICON = PropertiesBlock::ICON;
    const EDITOR = PropertiesBlock::EDITOR;
    const CACHEABLE = PropertiesBlock::CACHEABLE;
    const FIELDS = PropertiesBlock::FIELDS;
    const DEFAULT_CONFIG = PropertiesBlock::DEFAULT_CONFIG;
    const CREATED_BY_USER_ID = TrackableProperties::CREATED_BY_USER_ID;
    const CREATED_REASON = TrackableProperties::CREATED_REASON;
}
