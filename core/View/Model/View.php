<?php

namespace Zrcms\Core\View\Model;

use Zrcms\Content\Model\Content;
use Zrcms\Content\Model\PropertiesContent;
use Zrcms\Core\Page\Model\PageContainerCmsResource;
use Zrcms\Core\Page\Model\Page;
use Zrcms\Core\Site\Model\SiteCmsResource;
use Zrcms\Core\Site\Model\Site;
use Zrcms\Core\Theme\Model\Layout;
use Zrcms\Core\Theme\Model\LayoutCmsResource;

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
