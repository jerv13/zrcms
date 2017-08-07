<?php

namespace Zrcms\ContentCore\Block\Model;

use Zrcms\Content\Model\ComponentConfigFields;
use Zrcms\Content\Model\Trackable;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BlockComponentConfigFields extends ComponentConfigFields
{
    const DEFAULT_CONFIG = PropertiesBlockComponent::DEFAULT_CONFIG;
    const CACHEABLE = PropertiesBlockComponent::CACHEABLE;
    const RENDERER = PropertiesBlockComponent::RENDERER;
    const DATA_PROVIDER = PropertiesBlockComponent::DATA_PROVIDER;
    const FIELDS = PropertiesBlockComponent::FIELDS;
    const ICON = PropertiesBlockComponent::ICON;
    const CATEGORY = PropertiesBlockComponent::CATEGORY;
    const LABEL = PropertiesBlockComponent::LABEL;
    const DESCRIPTION = PropertiesBlockComponent::DESCRIPTION;
    const CONFIG_LOCATION = PropertiesBlockComponent::CONFIG_LOCATION;
    const COMPONENT_CONFIG_READER = PropertiesBlockComponent::COMPONENT_CONFIG_READER;

    /**
     * Default values
     *
     * @var array
     */
    protected $fields
        = [
            self::NAME => '',
            self::CREATED_BY_USER_ID => Trackable::UNKNOWN_USER_ID,
            self::CREATED_REASON => Trackable::UNKNOWN_REASON,

            self::DEFAULT_CONFIG => [],
            self::CACHEABLE => false,
            self::RENDERER => '',
            self::DATA_PROVIDER => '',
            self::FIELDS => [],
            self::ICON => '',
            self::CATEGORY => '',
            self::LABEL => '',
            self::DESCRIPTION => '',
            self::CONFIG_LOCATION => '',
            self::COMPONENT_CONFIG_READER => '',
        ];
}
