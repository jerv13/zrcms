<?php

namespace Rcms\Core\Url\Api;

use Rcms\Core\Url\Model\Schema;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildCmsUrlBasic implements BuildCmsUrl
{
    /**
     * @param string $siteId
     * @param string $type
     * @param string $path
     * @param array  $options
     * @param string $format
     *
     * @return mixed|string
     */
    public static function __invoke(
        string $siteId,
        string $type,
        string $path,
        array $options = [],
        $format = Schema::FORMAT
    ): string
    {
        $merged = array_merge(
            $options,
            [
                'siteId' => $siteId,
                'type' => $type,
                'path' => $path
            ]
        );

        foreach ($merged as $key => $value) {
            $format = str_replace('{{' . $key . '}}', '{{' . $value . '}}', $format);
        }

        return $format;
    }
}
