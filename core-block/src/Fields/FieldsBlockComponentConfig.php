<?php

namespace Zrcms\CoreBlock\Fields;

use Zrcms\Core\Fields\FieldsComponentConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsBlockComponentConfig extends FieldsComponentConfig
{
    const FIELD_MODEL_NAME = 'block-component-config';

    const DEFAULT_CONFIG = FieldsBlockComponent::DEFAULT_CONFIG;
    const CACHEABLE = FieldsBlockComponent::CACHEABLE;

    const RENDERER = FieldsBlockComponent::RENDERER;
    const DATA_PROVIDER = FieldsBlockComponent::DATA_PROVIDER;
    const FIELDS = FieldsBlockComponent::FIELDS;
    const TEMPLATE_FILE = FieldsBlockComponent::TEMPLATE_FILE;

    // client only
    const ICON = FieldsBlockComponent::ICON;
    const EDITOR = FieldsBlockComponent::EDITOR;
    const CATEGORY = FieldsBlockComponent::CATEGORY;
    const LABEL = FieldsBlockComponent::LABEL;
    const DESCRIPTION = FieldsBlockComponent::DESCRIPTION;
}
