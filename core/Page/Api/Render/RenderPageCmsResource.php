<?php

namespace Zrcms\Core\Page\Api\Render;

use Zrcms\Content\Api\Render\RenderCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Core\Page\Model\PageCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderPageCmsResource extends RenderCmsResource
{
    /**
     * @param PageCmsResource|CmsResource $pageCmsResource
     * @param array                       $renderData ['[page]' => '{html}']
     * @param array                       $options
     *
     * @return string
     */
    public function __invoke(
        CmsResource $pageCmsResource,
        array $renderData,
        array $options = []
    ): string;
}
