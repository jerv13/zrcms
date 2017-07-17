<?php

namespace Zrcms\Core\Container\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface BuildLayoutUri
{
    /**
     * @param int    $siteId
     * @param string $themeName
     * @param string $layoutName
     * @param array  $options
     *
     * @return string
     */
    public function __invoke(
        int $siteId,
        string $themeName,
        string $layoutName,
        array $options = []
    ): string;
}
