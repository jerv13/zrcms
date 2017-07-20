<?php

namespace Zrcms\Core\View\Api\Repository;

use Zrcms\Core\Theme\Model\Layout;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindTagNamesByLayout
{
    /**
     * @param Layout $layout
     * @param array  $options
     *
     * @return array ['{container-path}']
     */
    public function __invoke(Layout $layout, array $options = []);
}
