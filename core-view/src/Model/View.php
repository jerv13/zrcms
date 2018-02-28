<?php

namespace Zrcms\CoreView\Model;

use Zrcms\Core\Model\Content;
use Zrcms\CorePage\Model\PageCmsResource;
use Zrcms\CoreSite\Model\SiteCmsResource;
use Zrcms\CoreTheme\Model\LayoutCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface View extends Content
{
    /**
     * @param SiteCmsResource   $siteCmsResource
     * @param PageCmsResource   $pageCmsResource
     * @param LayoutCmsResource $layoutCmsResource
     * @param string            $strategy
     * @param array             $properties
     * @param string|null       $id
     *
     * @return View
     */
    public static function build(
        SiteCmsResource $siteCmsResource,
        PageCmsResource $pageCmsResource,
        LayoutCmsResource $layoutCmsResource,
        string $strategy,
        array $properties,
        $id = null
    ): View;

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
     * @return string
     */
    public function getStrategy(): string;

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
