<?php

namespace Zrcms\ContentCore\Container\Api\Action;

use Zrcms\Content\Api\Action\UnpublishCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Container\Model\ContainerCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UnpublishContainerCmsResource extends UnpublishCmsResource
{
    /**
     * @param ContainerCmsResource|CmsResource $containerCmsResource
     * @param string                           $unpublishedByUserId
     * @param string                           $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        CmsResource $containerCmsResource,
        string $unpublishedByUserId,
        string $unpublishReason
    ): bool;
}
