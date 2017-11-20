<?php

namespace Zrcms\ContentCore\Container\Api\Action;

use Zrcms\Content\Api\Action\PublishCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Container\Model\ContainerCmsResource;

/**
 * @deprecated
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishContainerCmsResource extends PublishCmsResource
{
    /**
     * @param ContainerCmsResource|CmsResource $containerCmsResource
     * @param string                           $publishedByUserId
     * @param string                           $publishReason
     * @param string|null                      $publishDate
     *
     * @return ContainerCmsResource|CmsResource
     */
    public function __invoke(
        CmsResource $containerCmsResource,
        string $publishedByUserId,
        string $publishReason,
        $publishDate = null
    ): CmsResource;
}
