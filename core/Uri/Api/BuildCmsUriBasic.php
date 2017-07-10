<?php

namespace Zrcms\Core\Uri\Api;

use Zrcms\Core\Uri\Model\Uri;

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
    public static function __invoke(
        Uri $uri,
        array $options = []
    ): string
    {
        $merged = array_merge(
            $options,
            [
                'siteId' => $uri->getSiteId(),
                'type' => $uri->getType(),
                'path' => $uri->getPath()
            ]
        );

        $schema = $uri->getSchema();

        foreach ($merged as $key => $value) {
            $schema = str_replace('{{' . $key . '}}', '{{' . $value . '}}', $schema);
        }

        return $schema;
    }
}
