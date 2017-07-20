<?php

namespace Zrcms\Core\ThemeLayout\Api\Repository;

use Zrcms\Content\Api\Repository\FindCmsResource;
use Zrcms\Content\Model\CmsResource;
use Zrcms\Core\ThemeLayout\Model\ThemeLayoutCmsResource;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface FindThemeLayoutCmsResource extends FindCmsResource
{
    /**
     * @param string $themeLayoutUri
     * @param array  $options
     *
     * @return ThemeLayoutCmsResource|CmsResource|null
     */
    public function __invoke(
        string $themeLayoutUri,
        array $options = []
    );
}
