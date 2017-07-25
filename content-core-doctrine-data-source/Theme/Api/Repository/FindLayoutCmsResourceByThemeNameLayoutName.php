<?php

namespace Zrcms\ContentCoreDoctrineDataSource\Theme\Api\Repository;

use Zrcms\Content\Model\CmsResource;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindLayoutCmsResourceByThemeNameLayoutName
{
    /**
     * @param string $themeName
     * @param string $layoutName
     * @param array  $options
     *
     * @return LayoutCmsResource|CmsResource|null
     */
    public function __invoke(
        string $themeName,
        string $layoutName,
        array $options = []
    );
}
