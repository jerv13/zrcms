<?php

namespace Zrcms\Core\Uri\Api;

use Zrcms\Core\Uri\Model\Uri;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface BuildCmsUri
{
    /**
     * @param Uri   $uri
     * @param array $options
     *
     * @return string
     */
    public static function __invoke(
        Uri $uri,
        array $options = []
    ): string;
}
