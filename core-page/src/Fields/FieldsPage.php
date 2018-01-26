<?php

namespace Zrcms\CorePage\Fields;

use Zrcms\Core\Fields\FieldsContent;
use Zrcms\CoreContainer\Fields\FieldsContainer;
use Zrcms\CorePage\Model\Page;
use Zrcms\CoreTheme\Fields\FieldsThemeComponent;
use Zrcms\Fields\Model\Fields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FieldsPage extends FieldsContent implements Fields
{
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const KEYWORDS = 'keywords';
    const LAYOUT = 'layout';
    const CONTAINERS_DATA = 'containersData';
    const PRE_RENDERED_HTML = 'html';

    const RENDER_TAGS_GETTER = 'renderTagsGetter';
    /**
     * @deprecated
     */
    const RENDERER = 'renderer';

    const DEFAULT_RENDER_TAGS_GETTER = 'blocks';
    const DEFAULT_RENDERER = 'rows';

    const DEFAULT_PRIMARY_LAYOUT_NAME = FieldsThemeComponent::DEFAULT_PRIMARY_LAYOUT_NAME;
}
