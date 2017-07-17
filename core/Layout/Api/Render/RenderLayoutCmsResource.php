<?php

namespace Zrcms\Core\Layout\Api\Render;

use Zrcms\Content\Api\Render\RenderCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Core\Layout\Model\LayoutCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderLayoutCmsResource extends RenderCmsResource
{
    /**
     * @param LayoutCmsResource|CmsResource $layoutCmsResource
     * @param array                         $renderData ['templateTag' => '{html}']
     * @param array                         $options
     *
     * @return string
     */
    public function __invoke(
        CmsResource $layoutCmsResource,
        array $renderData,
        array $options = []
    ): string;
}
