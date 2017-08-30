<?php

namespace Zrcms\ContentCore\Theme\Api\Repository;

use Zrcms\Content\Exception\CmsResourceNotExistsException;
use Zrcms\Content\Exception\ContentVersionNotExistsException;
use Zrcms\Content\Model\CmsResourceVersion;
use Zrcms\ContentCore\Theme\Model\LayoutCmsResourceVersion;

/**
 * Find published CmsResource by theme name and layout name
 *
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
     * @throws CmsResourceNotExistsException
     * @throws ContentVersionNotExistsException
     */
    public function __invoke(
        string $themeName,
        string $layoutName,
        array $options = []
    );
}
