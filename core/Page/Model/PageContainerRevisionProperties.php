<?php

namespace Zrcms\Core\Page\Model;

use Zrcms\Core\Container\Model\ContainerRevisionProperties;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PageContainerRevisionProperties
{
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const KEYWORDS = 'keywords';

    const LAYOUT = 'layout';

    const RENDER_DATA_GETTER = ContainerRevisionProperties::RENDER_DATA_GETTER;
    const RENDERER = ContainerRevisionProperties::RENDERER;
    const RENDER_TAG = '[page]';

    const PRE_RENDERED_HTML = 'html';
}
