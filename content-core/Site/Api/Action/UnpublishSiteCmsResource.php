<?php

namespace Zrcms\ContentCore\Site\Api\Action;

use Zrcms\Content\Api\Action\UnpublishCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UnpublishSiteCmsResource extends UnpublishCmsResource
{
    /**
     * @param SiteCmsResource|CmsResource $siteCmsResource
     * @param string                      $unpublishedByUserId
     * @param string                      $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        CmsResource $siteCmsResource,
        string $unpublishedByUserId,
        string $unpublishReason
    ): bool;
}
