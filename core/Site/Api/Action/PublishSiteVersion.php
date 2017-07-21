<?php

namespace Zrcms\Core\Site\Api\Action;

use Zrcms\Content\Api\Action\PublishContentVersion;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Core\Site\Model\SiteCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishSiteVersion extends PublishContentVersion
{
    /**
     * @param SiteCmsResource|CmsResource $siteCmsResource
     * @param string                      $publishedByUserId
     * @param string                      $publishReason
     *
     * @return CmsResource
     */
    public function __invoke(
        CmsResource $siteCmsResource,
        string $publishedByUserId,
        string $publishReason
    ): CmsResource;
}
