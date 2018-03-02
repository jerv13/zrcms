<?php

namespace Zrcms\CoreTheme\Fields;

use Zrcms\Core\Fields\FieldsComponentConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsLayoutComponentConfig extends FieldsComponentConfig
{
    const FIELD_MODEL_NAME = 'layout-component-config';

    const TEMPLATE_FILE = 'templateFile';
    const THEME_NAME = 'themeName';
    const RENDERER = FieldsLayoutComponent::RENDERER;
    const RENDER_TAGS_GETTER = FieldsLayoutComponent::RENDER_TAGS_GETTER;
    const RENDER_TAG_NAME_PARSER = FieldsLayoutComponent::RENDER_TAG_NAME_PARSER;
}
