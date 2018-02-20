<?php

namespace Zrcms\CoreView\Api;

use Psr\Http\Message\ServerRequestInterface;
use Zrcms\CorePage\Model\PageCmsResource;
use Zrcms\CoreSite\Model\SiteCmsResource;
use Zrcms\CoreTheme\Model\LayoutCmsResource;
use Zrcms\CoreView\Model\View;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface BuildView
{
    /**
     * @param ServerRequestInterface $request
     * @param SiteCmsResource        $siteCmsResource
     * @param PageCmsResource        $pageCmsResource
     * @param LayoutCmsResource      $layoutCmsResource
     *
     * @return View
     */
    public function __invoke(
        ServerRequestInterface $request,
        SiteCmsResource $siteCmsResource,
        PageCmsResource $pageCmsResource,
        LayoutCmsResource $layoutCmsResource
    ): View;
}
