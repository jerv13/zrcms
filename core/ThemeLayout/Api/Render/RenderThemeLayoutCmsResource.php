<?php

namespace Zrcms\Core\ThemeLayout\Api\Render;

use Zrcms\Content\Api\Render\RenderCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Core\ThemeLayout\Model\ThemeLayoutCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderThemeLayoutCmsResource extends RenderCmsResource
{
    /**
     * @param ThemeLayoutCmsResource|CmsResource $layoutCmsResource
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
