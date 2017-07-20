<?php

namespace Zrcms\Core\Theme\Api\Repository;

use Zrcms\Content\Api\Repository\FindComponent;
use Zrcms\Core\Theme\Model\ThemeComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindThemeComponent extends FindComponent
{
    /**
     * @param string $name
     * @param array  $options
     *
     * @return ThemeComponent|null
     */
    public function __invoke(
        string $name,
        array $options = []
    );
}
