<?php

namespace Rcms\Core\Container\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetContainerUrl
{
    /**
     * @param int    $siteId
     * @param string $containerName
     * @param array  $options
     *
     * @return string
     */
    public function __invoke(
        int $siteId,
        string $containerName,
        array $options = []
    ): string;
}
