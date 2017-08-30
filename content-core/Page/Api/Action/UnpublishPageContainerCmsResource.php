<?php

namespace Zrcms\ContentCore\Page\Api\Action;

use Zrcms\ContentCore\Container\Api\Action\UnpublishContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UnpublishPageContainerCmsResource extends UnpublishContainerCmsResource
{
    /**
     * @param string $pageContainerCmsResourceId
     * @param string $unpublishedByUserId
     * @param string $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        string $pageContainerCmsResourceId,
        string $unpublishedByUserId,
        string $unpublishReason
    ): bool;
}
