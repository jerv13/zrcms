<?php

namespace Zrcms\Core\Uri\Api;

use Zrcms\Core\Uri\Model\Uri;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ParseCmsUriBasic implements ParseCmsUri
{
    /**
     * @param Uri   $uri
     * @param array $options
     *
     * @return Uri
     */
    public static function __invoke(
        Uri $uri,
        array $options = []
    ): Uri
    {
        // @todo
    }
}
