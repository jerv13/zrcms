<?php

namespace Zrcms\Http;

use Zrcms\Http\Api\GetRouteOptions;
use Zrcms\Http\Api\GetRouteOptionsExpressiveConfigFactory;
use Zrcms\Http\Api\QueryParamValueDecode;
use Zrcms\Http\Api\QueryParamValueDecodeJsonFactory;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    GetRouteOptions::class => [
                        'factory' => GetRouteOptionsExpressiveConfigFactory::class,
                    ],

                    QueryParamValueDecode::class => [
                        'factory' => QueryParamValueDecodeJsonFactory::class,
                    ],
                ],
            ],
        ];
    }
}
