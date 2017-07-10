<?php

namespace Zrcms\Core\Uri\Api;

use Zrcms\Core\Uri\Model\Uri;
use Zrcms\Core\Uri\Model\UriBasic;
use Zrcms\Core\Uri\Schema\UriSchemaBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildCmsUriBasic implements BuildCmsUri
{
    /**
     * @param Uri   $uri
     * @param array $options
     *
     * @return string
     */
    public function __invoke(
        string $siteId,
        string $type,
        string $path,
        array $options = []
    ): string
    {
        $values = [
            'siteId' => $uri->getSiteId(),
            'type' => $uri->getType(),
            'path' => $uri->getPath()
        ];

        foreach ($values as $key => $value) {
            $schema = str_replace('{{' . $key . '}}', '{{' . $value . '}}', UriSchemaBasic::SCHEMA);
        }

        return $schema;
    }
}
