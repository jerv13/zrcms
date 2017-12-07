<?php

namespace Zrcms\CorePage\Api\CmsResource;

use Zrcms\Core\Api\CmsResource\UpsertCmsResource;
use Zrcms\Core\Model\CmsResource;
use Zrcms\CorePage\Model\PageTemplateCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UpsertPageTemplateCmsResource extends UpsertCmsResource
{
    /**
     * @param PageTemplateCmsResource|CmsResource $cmsResource
     * @param string                              $modifiedByUserId
     * @param string                              $publishReason
     * @param null                                $publishDate
     *
     * @return PageTemplateCmsResource|CmsResource
     */
    public function __invoke(
        CmsResource $cmsResource,
        string $modifiedByUserId,
        string $publishReason,
        $publishDate = null
    ): CmsResource;
}
