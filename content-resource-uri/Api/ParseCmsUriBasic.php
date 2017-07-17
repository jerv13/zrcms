<?php

namespace Zrcms\ContentResourceUri\Api;

use Zrcms\ContentResourceUri\Model\CmsUri;
use Zrcms\ContentResourceUri\Model\CmsUriBasic;
use Zrcms\ContentResourceUri\Schema\CmsUriSchemaBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ParseCmsUriBasic implements ParseCmsUri
{
    /**
     * @param string $uri
     * @param array  $options
     *
     * @return CmsUri
     * @throws \Exception
     */
    public function __invoke(
        string $uri,
        array $options = []
    ): CmsUri
    {
        if (!preg_match(CmsUriSchemaBasic::SCHEMA_REGEX, $uri, $matches)) {
            throw new \Exception('Invalid URI');
        }

        return new CmsUriBasic($matches['siteId'], $matches['type'], $matches['path']);
    }
}
