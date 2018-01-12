<?php

namespace Zrcms\HttpApi;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetDynamicApiValue
{
    /**
     * @param string $httpApiName
     * @param string $httpApiType
     * @param string $key
     * @param null   $default
     *
     * @return mixed
     */
    public function __invoke(
        string $httpApiName,
        string $httpApiType,
        string $key,
        $default = null
    );
}
