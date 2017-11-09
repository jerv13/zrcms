<?php

namespace Zrcms\Content\Api\Action;

/**
 * Unpublish a CmsResource and add an entry for Publish history
 *
 * @author James Jervis - https://github.com/jerv13
 */
interface UnpublishCmsResource
{
    /**
     * @param string      $cmsResourceId
     * @param string      $unpublishedByUserId
     * @param string      $unpublishReason
     * @param string|null $unpublishDate
     *
     * @return bool
     */
    public function __invoke(
        string $cmsResourceId,
        string $unpublishedByUserId,
        string $unpublishReason,
        string $unpublishDate = null
    ): bool;
}
