<?php

namespace Zrcms\CoreTheme\Fields;

use Zrcms\Core\Fields\FieldsComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsLayoutComponent extends FieldsComponent
{
    const FIELD_MODEL_NAME = 'layout-component';

    const THEME_NAME = 'themeName';
    const HTML = 'html';
    const RENDERER = 'renderer';
    const RENDER_TAGS_GETTER = 'renderTagsGetter';
    const RENDER_TAG_NAME_PARSER = 'renderTagNameParser';
}
