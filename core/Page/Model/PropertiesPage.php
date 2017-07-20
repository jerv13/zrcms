<?php

namespace Zrcms\Core\Page\Model;

use Zrcms\Core\Container\Model\PropertiesContainer;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PropertiesPage extends PropertiesContainer
{
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const KEYWORDS = 'keywords';

    const LAYOUT = 'layout';
    const RENDER_TAG = '[page]';

    const PRE_RENDERED_HTML = 'html';
}
