<?php

namespace Zrcms\ContentCore\Layout\Api\CmsResource;

use Zrcms\Content\Api\CmsResource\UpsertCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UpsertLayoutCmsResource extends UpsertCmsResource
{
    /**
     * @param LayoutCmsResource|CmsResource $cmsResource
     * @param string                        $modifiedByUserId
     * @param string                        $publishReason
     * @param null                          $publishDate
     *
     * @return LayoutCmsResource|CmsResource
     */
    public function __invoke(
        CmsResource $cmsResource,
        string $modifiedByUserId,
        string $publishReason,
        $publishDate = null
    ): CmsResource;
}
