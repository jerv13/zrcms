<?php

namespace Zrcms\HttpApi;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetDynamicApiValue
{
    /**
     * @param string $zrcmsImplementation
     * @param string $zrcmsApiName
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */
    public function __invoke(
        string $zrcmsImplementation,
        string $zrcmsApiName,
        string $key,
        $default = null
    );
}
