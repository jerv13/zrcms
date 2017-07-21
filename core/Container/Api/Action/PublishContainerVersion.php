<?php

namespace Zrcms\Core\Container\Api\Action;

use Zrcms\Content\Api\Action\PublishContentVersion;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Core\Container\Model\ContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishContainerVersion extends PublishContentVersion
{
    /**
     * @param ContainerCmsResource|CmsResource $containerCmsResource
     * @param string                           $publishedByUserId
     * @param string                           $publishReason
     *
     * @return CmsResource
     */
    public function __invoke(
        CmsResource $containerCmsResource,
        string $publishedByUserId,
        string $publishReason
    ): CmsResource;
}
