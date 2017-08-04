<?php

namespace Zrcms\ServiceAlias\Api;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetServiceFromAlias
{
    /**
     * @param string $namespace
     * @param string $serviceAlias
     * @param string $interfaceClass
     * @param string $defaultServiceName
     * @param array  $options
     *
     * @return object
     */
    public function __invoke(
        string $namespace,
        string $serviceAlias,
        string $interfaceClass,
        string $defaultServiceName,
        array $options = []
    );
}
