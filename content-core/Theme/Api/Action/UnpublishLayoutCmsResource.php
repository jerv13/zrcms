<?php

namespace Zrcms\ContentCore\Layout\Api\Action;

use Zrcms\Content\Api\Action\UnpublishCmsResource;

/**
 * @deprecated
 * @author James Jervis - https://github.com/jerv13
 */
interface UnpublishLayoutCmsResource extends UnpublishCmsResource
{
    /**
     * @param string      $layoutCmsResourceId
     * @param string      $unpublishedByUserId
     * @param string      $unpublishReason
     * @param string|null $unpublishDate
     *
     * @return bool
     */
    public function __invoke(
        string $layoutCmsResourceId,
        string $unpublishedByUserId,
        string $unpublishReason,
        $unpublishDate = null
    ): bool;
}
