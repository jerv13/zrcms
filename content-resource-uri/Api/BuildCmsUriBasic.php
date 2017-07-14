<?php

namespace Zrcms\ContentResourceUri\Api;

use Zrcms\ContentResourceUri\Schema\UriSchemaBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildCmsUriBasic implements BuildCmsUri
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
    ): string
    {
        $values = [
            'siteId' => $uri->getSiteId(),
            'type' => $uri->getType(),
            'path' => $uri->getPath()
        ];

        $schema = '';

        foreach ($values as $key => $value) {
            $schema = str_replace('{{' . $key . '}}', '{{' . $value . '}}', UriSchemaBasic::SCHEMA);
        }

        return $schema;
    }
}
