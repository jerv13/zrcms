<?php

namespace Zrcms\HttpApi;

use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetDynamicApiConfigAppConfig implements GetDynamicApiConfig
{
    protected $zrcmsHttpApiDynamicConfig;

    /**
     * @param array $zrcmsHttpApiDynamicConfig
     */
    public function __construct(
        array $zrcmsHttpApiDynamicConfig
    ) {
        $this->zrcmsHttpApiDynamicConfig = $zrcmsHttpApiDynamicConfig;
    }

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
    ): array {
        $zrcmsImplementationConfig = Param::getArray(
            $this->zrcmsHttpApiDynamicConfig,
            $zrcmsImplementation,
            null
        );

        if ($zrcmsImplementationConfig === null) {
            throw new DynamicApiConfigNotFound(
                'Implementation config not found: ' . $zrcmsImplementation
            );
        }

        $zrcmsApiNameConfig = Param::getArray(
            $zrcmsImplementationConfig,
            $zrcmsApiName
        );

        if ($zrcmsApiNameConfig === null) {
            throw new DynamicApiConfigNotFound(
                'API Name config not found: ' . $zrcmsApiName
                . ' for implementation: ' . $zrcmsImplementation
            );
        }

        return $zrcmsApiNameConfig;
    }
}
