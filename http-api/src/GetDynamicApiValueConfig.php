<?php

namespace Zrcms\HttpApi;

use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetDynamicApiValueConfig implements GetDynamicApiValue
{
    protected $zrcmsHttpApiConfig;

    /**
     * @param array $zrcmsHttpApiConfig
     */
    public function __construct(
        array $zrcmsHttpApiConfig
    ) {
        $this->zrcmsHttpApiConfig = $zrcmsHttpApiConfig;
    }

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
    ) {
        $httpApiNameConfig = Param::getArray(
            $this->zrcmsHttpApiConfig,
            $httpApiName,
            null
        );

        if ($httpApiNameConfig === null) {
            return $default;
        }

        $httpApiTypeConfig = Param::getArray(
            $httpApiNameConfig,
            $httpApiType
        );

        if ($httpApiTypeConfig === null) {
            return $default;
        }

        return Param::get(
            $httpApiTypeConfig,
            $key,
            $default
        );
    }
}
