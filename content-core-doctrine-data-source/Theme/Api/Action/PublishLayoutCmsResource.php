<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Layout\Api\Action;

use Zrcms\Content\Api\Action\PublishCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface PublishLayoutCmsResource extends PublishCmsResource
{
    /**
     * @param LayoutCmsResource|CmsResource $layoutCmsResource
     * @param string                        $publishedByUserId
     * @param string                        $publishReason
     *
     * @return CmsResource
     */
    public function __invoke(
        CmsResource $layoutCmsResource,
        string $publishedByUserId,
        string $publishReason
    ): CmsResource;
}
