<?php

namespace Zrcms\ContentResourceUri\Api;

use Zrcms\ContentResourceUri\Model\CmsUri;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ParseCmsUri
{
    /**
     * @param string $cmsUri
     * @param array  $options
     *
     * @return CmsUri
     */
    public function __invoke(
        string $cmsUri,
        array $options = []
    ): CmsUri;
}
