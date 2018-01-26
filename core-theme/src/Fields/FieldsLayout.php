<?php

namespace Zrcms\CoreTheme\Fields;

use Zrcms\Core\Fields\FieldsContent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsLayout extends FieldsContent
{
    const THEME_NAME = 'themeName';
    const NAME = 'name';

    const RENDERER = 'renderer';

    /** @deprecated NOT USE? */
    const RENDER_TAGS_GETTER = 'renderTagsGetter';
    const RENDER_TAG_NAME_PARSER = 'renderTagNameParser';
    const HTML = 'html';
}
