<?php

namespace Zrcms\ContentCore\View\Model;

use Zrcms\Content\Model\PropertiesContent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PropertiesView extends PropertiesContent
{
    const SITE_CMS_RESOURCE = 'siteCmsResource';
    const SITE = 'siteVersion';

    const PAGE_CONTAINER_CMS_RESOURCE = 'pageContainerCmsResource';
    const PAGE = 'page';

    const LAYOUT_CMS_RESOURCE = 'themeLayoutCmsResource';
    const LAYOUT = 'theme';

    const RENDERER = 'renderer';
}
