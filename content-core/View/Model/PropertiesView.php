<?php

namespace Zrcms\ContentCore\View\Model;

use Zrcms\Content\Model\PropertiesContent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PropertiesView extends PropertiesContent
{
    const SITE_CMS_RESOURCE = 'siteCmsResource';
    const PAGE_CONTAINER_CMS_RESOURCE = 'pageContainerCmsResource';
    const LAYOUT_CMS_RESOURCE = 'themeLayoutCmsResource';
    const RENDERER = 'renderer';

    /**
     * Default values
     *
     * @var array
     */
    protected $properties
        = [
            self::ID => '',
            self::SITE_CMS_RESOURCE => '',
            self::PAGE_CONTAINER_CMS_RESOURCE => '',
            self::LAYOUT_CMS_RESOURCE => '',
            self::RENDERER => '',
        ];
}
