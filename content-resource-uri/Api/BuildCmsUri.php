<?php

namespace Zrcms\ContentResourceUri\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface BuildCmsUri
{
    /**
     * @param string $siteId
     * @param string $type
     * @param string $path
     * @param array  $options
     *
     * @return string
     */
    public function __invoke(
        string $siteId,
        string $type,
        string $path,
        array $options = []
    ): string;
}
