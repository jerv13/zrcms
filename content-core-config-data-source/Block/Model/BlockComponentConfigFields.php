<?php

namespace Zrcms\ContentCoreConfigDataSource\Block\Model;

use Zrcms\ContentCore\Block\Model\PropertiesBlockComponent;
use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentConfigFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BlockComponentConfigFields extends ComponentConfigFields
{
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

            PropertiesBlockComponent::DEFAULT_CONFIG => [],
            PropertiesBlockComponent::CACHEABLE => false,
            PropertiesBlockComponent::RENDERER => '',
            PropertiesBlockComponent::DATA_PROVIDER => '',
            PropertiesBlockComponent::FIELDS => [],
            PropertiesBlockComponent::ICON => '',
            PropertiesBlockComponent::CATEGORY => '',
            PropertiesBlockComponent::LABEL => '',
            PropertiesBlockComponent::DESCRIPTION => '',
        ];
}
