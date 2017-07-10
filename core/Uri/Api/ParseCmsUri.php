<?php

namespace Zrcms\Core\Uri\Api;

use Zrcms\Core\Uri\Model\Uri;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ParseCmsUri
{
    /**
     * @param string $uri
     * @param array  $options
     * @param string $format
     *
     * @return Uri
     */
    public static function __invoke(
        string $uri,
        array $options = [],
        $format = Uri::SCHEMA
    ): Uri;
}
