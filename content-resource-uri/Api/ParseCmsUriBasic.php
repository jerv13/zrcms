<?php

namespace Zrcms\ContentResourceUri\Api;

use Zrcms\ContentResourceUri\Model\Uri;
use Zrcms\ContentResourceUri\Model\UriBasic;
use Zrcms\ContentResourceUri\Schema\UriSchemaBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ParseCmsUriBasic implements ParseCmsUri
{
    /**
     * @param string $uri
     * @param array  $options
     *
     * @return Uri
     * @throws \Exception
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
