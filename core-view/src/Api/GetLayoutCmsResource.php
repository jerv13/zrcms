<?php

namespace Zrcms\CoreView\Api;

use Zrcms\CoreTheme\Model\LayoutCmsResource;
use Zrcms\CoreView\Exception\LayoutNotFound;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetLayoutCmsResource
{
    /**
     * @param string $themeName
     * @param string $layoutName
     *
     * @return LayoutCmsResource
     * @throws LayoutNotFound
     */
    public function __invoke(
        string $themeName,
        string $layoutName
    ): LayoutCmsResource;
}
