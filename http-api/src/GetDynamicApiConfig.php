<?php

namespace Zrcms\HttpApi;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetDynamicApiConfig
{
    /**
     * @param string $zrcmsImplementation
     * @param string $zrcmsApiName
     *
     * @return array
     * @throws DynamicApiConfigNotFound
     */
    public function __invoke(
        string $zrcmsImplementation,
        string $zrcmsApiName
    ): array;
}
