<?php

namespace Zrcms\ContentCore\Layout\Api\Action;

use Zrcms\Content\Api\Action\UnpublishCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UnpublishLayoutCmsResource extends UnpublishCmsResource
{
    /**
     * @param string $layoutCmsResourceId
     * @param string $unpublishedByUserId
     * @param string $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        string $layoutCmsResourceId,
        string $unpublishedByUserId,
        string $unpublishReason
    ): bool;
}
