<?php

namespace Zrcms\Core\Layout\Api;

use Rcm\Entity\Page;
use Zrcms\Core\Layout\Model\Layout;

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
     * @return array
     */
    public function __invoke(
        Layout $layout,
        Page $page,
        array $options = []
    ): array;
}
