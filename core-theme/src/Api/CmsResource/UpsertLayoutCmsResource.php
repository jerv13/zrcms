<?php

namespace Zrcms\CoreTheme\Api\CmsResource;

use Zrcms\Core\Api\CmsResource\UpsertCmsResource;
use Zrcms\Core\Exception\CmsResourceNotExists;
use Zrcms\Core\Exception\ContentVersionNotExists;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CoreTheme\Model\LayoutCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UpsertLayoutCmsResource extends UpsertCmsResource
{
    /**
     * @param LayoutCmsResource|CmsResource $cmsResource
     * @param string                        $contentVersionId
     * @param string                        $modifiedByUserId
     * @param string                        $modifiedReason
     * @param string|null                   $modifiedDate
     *
     * @return LayoutCmsResource|CmsResource
     * @throws CmsResourceNotExists
     * @throws ContentVersionNotExists
     */
    public function __invoke(
        CmsResource $cmsResource,
        string $contentVersionId,
        string $modifiedByUserId,
        string $modifiedReason,
        $modifiedDate = null
    ): CmsResource;
}
