<?php

namespace Zrcms\Core\Page\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PageProperties
{
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const KEYWORDS = 'keywords';

    const LAYOUT = 'layout';
    const PATH = 'path';

    const RENDER_NAMESPACE = '[page]';
    const RENDER = 'render';

    const PRE_RENDERED_HTML = 'html';
}
