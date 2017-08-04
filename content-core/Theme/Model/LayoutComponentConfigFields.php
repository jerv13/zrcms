<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Model\ComponentConfigFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class LayoutComponentConfigFields extends ComponentConfigFields
{
    const TEMPLATE_FILE = 'templateFile';
    const RENDERER = PropertiesLayoutComponent::RENDERER;
    const RENDER_DATA_GETTER = PropertiesLayoutComponent::RENDER_DATA_GETTER;
    const RENDER_TAG_NAME_PARSER = PropertiesLayoutComponent::RENDER_TAG_NAME_PARSER;

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
            self::TEMPLATE_FILE => '',
            self::RENDERER => '',
            self::RENDER_DATA_GETTER => '',
            self::RENDER_TAG_NAME_PARSER => '',
        ];
}
