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
     * @return mixed|null
     * @throws \Exception
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
            throw new \Exception(
                'Implementation config not found: ' . $zrcmsImplementation
            );
        }

        $zrcmsApiNameConfig = Param::getArray(
            $zrcmsImplementationConfig,
            $zrcmsApiName
        );

        if ($zrcmsApiNameConfig === null) {
            throw new \Exception(
                'API Name config not found: ' . $zrcmsApiName
                . ' for implementation: ' . $zrcmsImplementation
            );
        }

        return Param::get(
            $zrcmsApiNameConfig,
            $key,
            $default
        );
    }
}
