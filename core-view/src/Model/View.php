<?php

namespace Zrcms\CoreView\Model;

use Zrcms\Core\Model\Content;
use Zrcms\CorePage\Model\PageCmsResource;
use Zrcms\CoreSite\Model\SiteCmsResource;
use Zrcms\CoreTheme\Model\LayoutCmsResource;

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

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return View
     */
    public function withProperty(
        string $name,
        $value
    ): View;
}
