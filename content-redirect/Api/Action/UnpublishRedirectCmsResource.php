<?php

namespace Zrcms\ContentRedirect\Api\Action;

use Zrcms\Content\Api\Action\UnpublishCmsResource;

/**
 * @deprecated
 * @author James Jervis - https://github.com/jerv13
 */
interface UnpublishRedirectCmsResource extends UnpublishCmsResource
{
    /**
     * @param string      $redirectCmsResourceId
     * @param string      $unpublishedByUserId
     * @param string      $unpublishReason
     * @param string|null $unpublishDate
     *
     * @return bool
     */
    public function __invoke(
        string $redirectCmsResourceId,
        string $unpublishedByUserId,
        string $unpublishReason,
        $unpublishDate = null
    ): bool;
}
