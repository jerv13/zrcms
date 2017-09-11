<?php

namespace Zrcms\ContentCore\View\Model;

use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResource;
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
     * @return PageContainerCmsResource
     */
    public function getPageContainerCmsResource(): PageContainerCmsResource;

    /**
     * @return LayoutCmsResource
     */
    public function getLayoutCmsResource(): LayoutCmsResource;
}
