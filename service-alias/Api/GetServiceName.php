<?php

namespace Zrcms\ServiceAlias\Api;

use Zrcms\ServiceAlias\Exception\ServiceAliasNotFound;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetServiceName
{
    /**
     * @param string $namespace
     * @param string $serviceAlias
     * @param string $defaultServiceName
     * @param array  $options
     *
     * @return string
     * @throws ServiceAliasNotFound
     */
    public function __invoke(
        string $namespace,
        string $serviceAlias,
        string $defaultServiceName,
        array $options = []
    ): string;
}
