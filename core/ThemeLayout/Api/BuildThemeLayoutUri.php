<?php

namespace Zrcms\Core\Container\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface BuildThemeLayoutUri
{
    /**
     * @param string   $themeName
     * @param string   $layoutName
     * @param int|null $siteId
     * @param array    $options
     *
     * @return string
     */
    public function __invoke(
        string $themeName,
        string $layoutName,
        int $siteId = null,
        array $options = []
    ): string;
}
