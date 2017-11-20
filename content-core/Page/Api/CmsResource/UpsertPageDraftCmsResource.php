<?php

namespace Zrcms\ContentCore\Page\Api\CmsResource;

use Zrcms\Content\Api\CmsResource\UpsertCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Page\Model\PageDraftCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UpsertPageDraftCmsResource extends UpsertCmsResource
{
    /**
     * @param PageDraftCmsResource|CmsResource $cmsResource
     * @param string                           $modifiedByUserId
     * @param string                           $publishReason
     * @param null                             $publishDate
     *
     * @return PageDraftCmsResource|CmsResource
     */
    public function __invoke(
        CmsResource $cmsResource,
        string $modifiedByUserId,
        string $publishReason,
        $publishDate = null
    ): CmsResource;
}
