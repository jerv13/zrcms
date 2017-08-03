<?php

namespace Zrcms\ServiceAlias\Api;

use Zrcms\ServiceAlias\Exception\ServiceAliasNotFoundException;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetService
{
    /**
     * @param string $type
     * @param string $serviceAlias
     * @param string $interfaceClass
     * @param string $defaultServiceName
     * @param array  $options
     *
     * @return string
     */
    public function __invoke(
        string $type,
        string $serviceAlias,
        string $interfaceClass,
        string $defaultServiceName,
        array $options = []
    ): string;
}
