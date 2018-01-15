<?php

namespace Zrcms\Http;

use Zrcms\Http\Api\GetRouteOptions;
use Zrcms\Http\Api\GetRouteOptionsExpressiveConfigFactory;
use Zrcms\Http\Api\ValidateId;

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

                    ValidateId::class => [
                        'factory' => GetRouteOptionsExpressiveConfigFactory::class,
                    ],
                ],
            ],
        ];
    }
}
