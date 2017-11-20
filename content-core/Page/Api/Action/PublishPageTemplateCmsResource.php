<?php

namespace Zrcms\ContentCore\Page\Api\Action;

use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Page\Model\PageCmsResource;

/**
 * @deprecated
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishPageTemplateCmsResource extends PublishPageCmsResource
{
    /**
     * @param PageCmsResource|CmsResource $pageCmsResource
     * @param string                      $publishedByUserId
     * @param string                      $publishReason
     * @param string|null                 $publishDate
     *
     * @return PageCmsResource|CmsResource
     */
    public function __invoke(
        CmsResource $pageCmsResource,
        string $publishedByUserId,
        string $publishReason,
        $publishDate = null
    ): CmsResource;
}
