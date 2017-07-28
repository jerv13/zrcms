<?php

namespace Zrcms\ContentCore\Page\Model;

use Zrcms\ContentCore\Container\Model\PropertiesContainer;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PropertiesPage extends PropertiesContainer
{
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const KEYWORDS = 'keywords';

    const LAYOUT = 'layout';

    const PRE_RENDERED_HTML = 'html';
}
