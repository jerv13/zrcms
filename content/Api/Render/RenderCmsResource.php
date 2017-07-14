<?php

namespace Zrcms\Content\Api\Render;

use Zrcms\Content\Model\CmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderCmsResource
{
    /**
     * @param CmsResource $cmsResource
     * @param array       $renderData ['templateTag' => '{html}']
     * @param array       $options
     *
     * @return string
     */
    public function __invoke(
        CmsResource $cmsResource,
        array $renderData,
        array $options = []
    ): string;
}
