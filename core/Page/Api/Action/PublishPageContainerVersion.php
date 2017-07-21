<?php

namespace Zrcms\Core\Page\Api\Action;

use Zrcms\Content\Model\CmsResource;
use Zrcms\Core\Container\Api\Action\PublishContainerVersion;
use Zrcms\Core\Page\Model\PageContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishPageContainerVersion extends PublishContainerVersion
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
