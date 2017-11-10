<?php

namespace Zrcms\ContentCore\Page\Api\Action;

use Zrcms\ContentCore\Container\Api\Action\UnpublishContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UnpublishPageCmsResource extends UnpublishContainerCmsResource
{
    /**
     * @param string      $pageCmsResourceId
     * @param string      $unpublishedByUserId
     * @param string      $unpublishReason
     * @param string|null $unpublishDate
     *
     * @return bool
     */
    public function __invoke(
        string $pageCmsResourceId,
        string $unpublishedByUserId,
        string $unpublishReason,
        $unpublishDate = null
    ): bool;
}
