<?php

namespace Zrcms\ContentCore\View\Model;

use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Page\Model\PageCmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResource;

/**
 * ViewModel
 *
 * @author James Jervis - https://github.com/jerv13
 */
interface View extends Content
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
     * @return LayoutCmsResource
     */
    public function getLayoutCmsResource(): LayoutCmsResource;
}
