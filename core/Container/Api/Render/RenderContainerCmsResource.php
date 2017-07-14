<?php

namespace Zrcms\Core\Container\Api\Render;

use Zrcms\Content\Api\Render\RenderCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Core\Container\Model\Container;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderContainerCmsResource extends RenderCmsResource
{
    /**
     * @param Container|CmsResource $container
     * @param array                 $renderData ['templateTag' => '{html}']
     * @param array                 $options
     *
     * @return string
     */
    public function __invoke(
        CmsResource $container,
        array $renderData,
        array $options = []
    ): string;
}
