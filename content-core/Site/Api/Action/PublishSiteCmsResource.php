<?php

namespace Zrcms\ContentCore\Site\Api\Action;

use Zrcms\Content\Api\Action\PublishCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Site\Model\SiteCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishSiteCmsResource extends PublishCmsResource
{
    /**
     * @param SiteCmsResource|CmsResource $siteCmsResource
     * @param string                      $publishedByUserId
     * @param string                      $publishReason
     * @param string|null                 $publishDate
     *
     * @return SiteCmsResource|CmsResource
     */
    public function __invoke(
        CmsResource $siteCmsResource,
        string $publishedByUserId,
        string $publishReason,
        $publishDate = null
    ): CmsResource;
}
