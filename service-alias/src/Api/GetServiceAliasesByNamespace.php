<?php

namespace Zrcms\ServiceAlias\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetServiceAliasesByNamespace
{
    /**
     * @param string $namespace
     * @param array  $options
     *
     * @return array
     */
    public function __invoke(
        string $namespace,
        array $options = []
    ): array;
}
