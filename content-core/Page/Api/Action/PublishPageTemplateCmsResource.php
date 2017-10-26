<?php

namespace Zrcms\ContentCore\Page\Api\Action;

use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Page\Model\PageCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishPageTemplateCmsResource extends PublishPageCmsResource
{
    /**
     * @param PageCmsResource|CmsResource $pageCmsResource
     * @param string                      $publishedByUserId
     * @param string                      $publishReason
     *
     * @return CmsResource
     */
    public function __invoke(
        CmsResource $pageCmsResource,
        string $publishedByUserId,
        string $publishReason
    ): CmsResource;
}
