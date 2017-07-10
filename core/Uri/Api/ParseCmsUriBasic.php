<?php

namespace Zrcms\Core\Uri\Api;

use Zrcms\Core\Uri\Model\Uri;
use Zrcms\Core\Uri\Model\UriBasic;
use Zrcms\Core\Uri\Schema\UriSchemaBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ParseCmsUriBasic implements ParseCmsUri
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
    ): Uri {
        if (!preg_match(UriSchemaBasic::SCHEMA_REGEX, $uri, $matches)) {
            throw new \Exception('Invalid URI');
        }

        return new UriBasic($matches['siteId'], $matches['type'], $matches['path']);
    }
}
