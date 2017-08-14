<?php

namespace Zrcms\ContentCore\Theme\Api\Repository;

use Zrcms\Content\Model\CmsResourceVersion;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResourceVersion;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindLayoutCmsResourceVersionByThemeNameLayoutName
{
    /**
     * @param string $themeName
     * @param string $layoutName
     * @param array  $options
     *
     * @return LayoutCmsResourceVersion|CmsResourceVersion|null
     */
    public function __invoke(
        string $themeName,
        string $layoutName,
        array $options = []
    );
}
