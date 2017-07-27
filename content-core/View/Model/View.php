<?php

namespace Zrcms\ContentCore\View\Model;

use Zrcms\Content\Model\Content;
use Zrcms\ContentCore\Page\Model\Page;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResource;
use Zrcms\ContentCore\Site\Model\Site;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;
use Zrcms\ContentCore\Theme\Model\Layout;
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
     * @return Site
     */
    public function getSite(): Site;

    /**
     * @return PageContainerCmsResource
     */
    public function getPageContainerCmsResource(): PageContainerCmsResource;

    /**
     * @return Page
     */
    public function getPage(): Page;

    /**
     * @return LayoutCmsResource
     */
    public function getLayoutCmsResource(): LayoutCmsResource;

    /**
     * @return Layout
     */
    public function getLayout(): Layout;
}
