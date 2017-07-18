<?php

namespace Zrcms\Core\PageView\Model;

use Zrcms\Content\Model\Content;
use Zrcms\Core\ThemeLayout\Model\ThemeLayoutCmsResource;
use Zrcms\Core\Page\Model\PageCmsResource;
use Zrcms\Core\Site\Model\SiteCmsResource;
use Zrcms\Core\Theme\Model\Theme;

/**
 * ViewModel
 *
 * @author James Jervis - https://github.com/jerv13
 */
interface PageView extends Content
{
    /**
     * @return SiteCmsResource
     */
    public function getSiteCmsResource(): SiteCmsResource;

    /**
     * @return PageCmsResource
     */
    public function getPageCmsResource(): PageCmsResource;

    /**
     * @return Theme
     */
    public function getTheme(): Theme;

    /**
     * @return ThemeLayoutCmsResource
     */
    public function getThemeLayoutCmsResource(): ThemeLayoutCmsResource;

    /**
     * @return array
     */
    public function getLayoutRenderData(): array;
}
