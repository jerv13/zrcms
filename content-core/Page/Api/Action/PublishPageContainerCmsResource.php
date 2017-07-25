<?php

namespace Zrcms\ContentCore\Page\Api\Action;

use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Container\Api\Action\PublishContainerCmsResource;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishPageContainerCmsResource extends PublishContainerCmsResource
{
    /**
     * @param PageContainerCmsResource|CmsResource $pageContainerCmsResource
     * @param string                               $publishedByUserId
     * @param string                               $publishReason
     *
     * @return CmsResource
     */
    public function __invoke(
        CmsResource $pageContainerCmsResource,
        string $publishedByUserId,
        string $publishReason
    ): CmsResource;
}
