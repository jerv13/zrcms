<?php

namespace Zrcms\ContentCore\Layout\Api\Action;

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
     * @param string|null $publishDate
     *
     * @return LayoutCmsResource|CmsResource
     */
    public function __invoke(
        CmsResource $layoutCmsResource,
        string $publishedByUserId,
        string $publishReason,
        $publishDate = null
    ): CmsResource;
}
