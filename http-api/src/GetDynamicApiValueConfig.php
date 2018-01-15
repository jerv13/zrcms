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
    ) {
        $zrcmsImplementationConfig = Param::getArray(
            $this->zrcmsHttpApiConfig,
            $zrcmsImplementation,
            null
        );

        if ($zrcmsImplementationConfig === null) {
            return $default;
        }

        $zrcmsApiNameConfig = Param::getArray(
            $zrcmsImplementationConfig,
            $zrcmsApiName
        );

        if ($zrcmsApiNameConfig === null) {
            return $default;
        }

        return Param::get(
            $zrcmsApiNameConfig,
            $key,
            $default
        );
    }
}
