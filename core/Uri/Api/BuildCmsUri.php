<?php

namespace Zrcms\Core\Uri\Api;

use Zrcms\Core\Uri\Model\Uri;

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
     * @param string $format
     *
     * @return mixed|string
     */
    public static function __invoke(
        string $siteId,
        string $type,
        string $path,
        array $options = [],
        $format = Uri::SCHEMA
    ): string;
}
