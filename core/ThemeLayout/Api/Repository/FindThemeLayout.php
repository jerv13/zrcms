<?php

namespace Zrcms\Core\ThemeLayout\Api\Repository;

use Zrcms\Content\Api\Repository\FindContent;
use Zrcms\Content\Model\Content;
use Zrcms\Core\ThemeLayout\Model\ThemeLayout;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindThemeLayout extends FindContent
{
    /**
     * @param string $id
     * @param array  $options
     *
     * @return ThemeLayout|Content|null
     */
    public function __invoke(
        string $id,
        array $options = []
    );
}
