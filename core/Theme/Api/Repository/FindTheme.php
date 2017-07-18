<?php

namespace Zrcms\Core\Theme\Api\Repository;

use Zrcms\Core\Theme\Model\Theme;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindTheme
{
    /**
     * @param string   $name
     * @param array $options
     *
     * @return Theme|null
     */
    public function __invoke(
        $name,
        array $options = []
    );
}
