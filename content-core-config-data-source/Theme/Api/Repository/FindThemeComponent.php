<?php

namespace Zrcms\ContentCoreConfigDataSource\Theme\Api;

use Zrcms\ContentCore\Theme\Model\ThemeComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindThemeComponent implements \Zrcms\ContentCore\Theme\Api\Repository\FindThemeComponent
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
    ) {

    }
}
