<?php

namespace Zrcms\ContentCore\Container\Api\Action;

use Zrcms\Content\Api\Action\UnpublishCmsResource;

/**
 * @deprecated
 * @author James Jervis - https://github.com/jerv13
 */
interface UnpublishContainerCmsResource extends UnpublishCmsResource
{
    /**
     * @param string      $containerCmsResourceId
     * @param string      $unpublishedByUserId
     * @param string      $unpublishReason
     * @param string|null $unpublishDate
     *
     * @return bool
     */
    public function __invoke(
        string $containerCmsResourceId,
        string $unpublishedByUserId,
        string $unpublishReason,
        $unpublishDate = null
    ): bool;
}
