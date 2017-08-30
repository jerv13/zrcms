<?php

namespace Zrcms\ContentCore\Container\Api\Action;

use Zrcms\Content\Api\Action\UnpublishCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UnpublishContainerCmsResource extends UnpublishCmsResource
{
    /**
     * @param string $containerCmsResourceId
     * @param string $unpublishedByUserId
     * @param string $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        string $containerCmsResourceId,
        string $unpublishedByUserId,
        string $unpublishReason
    ): bool;
}
