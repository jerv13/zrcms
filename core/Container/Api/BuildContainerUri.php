<?php

namespace Zrcms\Core\Container\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface BuildContainerUri
{
    /**
     * @param int    $siteId
     * @param string $containerPath
     * @param array  $options
     *
     * @return string
     */
    public function __invoke(
        int $siteId,
        string $containerPath,
        array $options = []
    ): string;
}
