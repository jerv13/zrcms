<?php

namespace Zrcms\ContentCoreConfigDataSource\Content\Model;

use Zrcms\Content\Model\PropertiesComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ComponentRegistryFields
{
    const NAME = PropertiesComponent::NAME;
    const CONFIG_LOCATION = PropertiesComponent::CONFIG_LOCATION;
    const COMPONENT_CONFIG_READER = PropertiesComponent::COMPONENT_CONFIG_READER;
    const COMPONENT_CLASS = PropertiesComponent::COMPONENT_CLASS;

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::NAME => '',
            self::CONFIG_LOCATION => '',
            self::COMPONENT_CONFIG_READER => '',
            self::COMPONENT_CLASS => '',
        ];
}
