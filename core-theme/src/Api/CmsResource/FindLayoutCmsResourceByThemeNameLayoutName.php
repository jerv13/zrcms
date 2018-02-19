<?php

namespace Zrcms\CoreTheme\Api\CmsResource;

use Zrcms\CoreTheme\Model\LayoutCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindLayoutCmsResourceByThemeNameLayoutName
{
    /**
     * @param string    $themeName
     * @param string    $layoutName
     * @param bool|null $published
     * @param array     $options
     *
     * @return LayoutCmsResource|null
     */
    public function __invoke(
        string $themeName,
        string $layoutName,
        $published = true,
        array $options = []
    );
}
