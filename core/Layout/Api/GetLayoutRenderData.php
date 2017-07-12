<?php

namespace Zrcms\Core\Layout\Api;

use Rcm\Entity\Page;
use Zrcms\Core\Layout\Model\Layout;
use Zrcms\Core\RenderData\Model\RenderDataCollection;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetLayoutRenderData
{
    /**
     * @param Layout $layout
     * @param Page   $page
     * @param array  $options
     *
     * @return RenderDataCollection
     */
    public function __invoke(
        Layout $layout,
        Page $page,
        array $options = []
    ): RenderDataCollection;
}
