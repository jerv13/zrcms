<?php

namespace Zrcms\Core\Container\Api\Repository;

use Zrcms\Core\ThemeLayout\Model\Layout;

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
