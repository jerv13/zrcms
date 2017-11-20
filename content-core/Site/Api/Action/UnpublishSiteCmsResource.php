<?php

namespace Zrcms\ContentCore\Site\Api\Action;

use Zrcms\Content\Api\Action\UnpublishCmsResource;

/**
 * @deprecated
 * @author James Jervis - https://github.com/jerv13
 */
interface UnpublishSiteCmsResource extends UnpublishCmsResource
{
    /**
     * @param string      $siteCmsResourceId
     * @param string      $unpublishedByUserId
     * @param string      $unpublishReason
     * @param string|null $unpublishDate
     *
     * @return bool
     */
    public function __invoke(
        string $siteCmsResourceId,
        string $unpublishedByUserId,
        string $unpublishReason,
        $unpublishDate = null
    ): bool;
}
