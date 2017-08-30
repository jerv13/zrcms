<?php

namespace Zrcms\ContentCore\Site\Api\Action;

use Zrcms\Content\Api\Action\UnpublishCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UnpublishSiteCmsResource extends UnpublishCmsResource
{
    /**
     * @param string $siteCmsResourceId
     * @param string $unpublishedByUserId
     * @param string $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        string $siteCmsResourceId,
        string $unpublishedByUserId,
        string $unpublishReason
    ): bool;
}
