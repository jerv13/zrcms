<?php

namespace Zrcms\ContentCore\Layout\Api\Action;

use Zrcms\Content\Api\Action\UnpublishCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface UnpublishLayoutCmsResource extends UnpublishCmsResource
{
    /**
     * @param LayoutCmsResource|CmsResource $layoutCmsResource
     * @param string                        $unpublishedByUserId
     * @param string                        $unpublishReason
     *
     * @return bool
     */
    public function __invoke(
        CmsResource $layoutCmsResource,
        string $unpublishedByUserId,
        string $unpublishReason
    ): bool;
}
