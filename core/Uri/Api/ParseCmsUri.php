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
     * @param array $options
     *
     * @return Uri
     */
    public function __invoke(
        string $uri,
        array $options = []
    ): Uri;
}
