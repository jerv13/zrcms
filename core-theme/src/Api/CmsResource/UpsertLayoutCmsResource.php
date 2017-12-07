<?php

namespace Zrcms\CoreTheme\Api\CmsResource;

use Zrcms\Core\Api\CmsResource\UpsertCmsResource;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreTheme\Model\LayoutCmsResource;

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
