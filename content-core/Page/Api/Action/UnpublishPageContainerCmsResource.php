<?php

namespace Zrcms\ContentCore\Page\Api\Action;

use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Container\Api\Action\UnpublishContainerCmsResource;
use Zrcms\ContentCore\Page\Model\PageContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UnpublishPageContainerCmsResource extends UnpublishContainerCmsResource
{
    /**
     * @param PageContainerCmsResource|CmsResource $pageContainerCmsResource
     * @param string                           $unpublishedByUserId
     * @param string                           $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        CmsResource $pageContainerCmsResource,
        string $unpublishedByUserId,
        string $unpublishReason
    ): bool;
}
