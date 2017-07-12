<?php

namespace Zrcms\Core\Layout\Api;

use Zrcms\Core\Layout\Model\Layout;
use Zrcms\Core\Page\Model\Page;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderLayout
{
    /**
     * @param Layout $layout
     * @param Page   $page
     * @param array  $options
     *
     * @return string
     */
    public function __invoke(
        Layout $layout,
        Page $page,
        array $renderData,
        array $options = []
    ):string;
}
