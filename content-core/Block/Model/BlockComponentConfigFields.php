<?php

namespace Zrcms\ContentCore\Block\Model;

use Zrcms\Content\Model\ComponentConfigFields;

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

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::NAME => '',
            self::CREATED_BY_USER_ID => '',
            self::CREATED_REASON => '',

            self::DEFAULT_CONFIG => [],
            self::CACHEABLE => false,
            self::RENDERER => '',
            self::DATA_PROVIDER => '',
            self::FIELDS => [],
            self::ICON => '',
            self::CATEGORY => '',
            self::LABEL => '',
            self::DESCRIPTION => '',
        ];
}
