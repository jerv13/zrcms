<?php

namespace Zrcms\Core\Block\Api;

use Zrcms\Core\Layout\Model\Layout;
use Zrcms\Core\Page\Model\Page;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface RenderLayout
{
    public function __invoke(
        Layout $layout,
        Page $page,
        array $blockInstances
    );
}
