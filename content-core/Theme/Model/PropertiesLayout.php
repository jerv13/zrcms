<?php

namespace Zrcms\ContentCore\Theme\Model;

use Zrcms\Content\Model\PropertiesContent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PropertiesLayout extends PropertiesContent
{
    const THEME_NAME = 'themeName';
    const NAME = 'name';

    const RENDERER = 'renderer';
    const RENDER_DATA_GETTER = 'renderDataGetter';
    const RENDER_TAG_NAME_PARSER = 'renderTagNameParser';
    const HTML = 'html';

    const URI_NAMESPACE = 'theme-layout';
}
