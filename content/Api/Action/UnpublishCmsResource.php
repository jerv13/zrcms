<?php

namespace Zrcms\Content\Api\Action;

use Zrcms\Content\Model\CmsResource;

/**
 * Unpublish a CmsResource and add an entry for Publish history
 *
 * @author James Jervis - https://github.com/jerv13
 */
interface UnpublishCmsResource
{
    /**
     * @param CmsResource $cmsResource
     * @param string      $unpublishedByUserId
     * @param string      $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        CmsResource $cmsResource,
        string $unpublishedByUserId,
        string $unpublishReason
    ): bool;
}
