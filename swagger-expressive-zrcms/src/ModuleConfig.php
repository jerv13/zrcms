<?php

namespace Zrcms\SwaggerExpressiveZrcms;

use Zrcms\SwaggerExpressive\Api\IsAllowedSwagger;
use Zrcms\SwaggerExpressiveZrcms\Api\IsAllowedSwaggerZrcmsRcmUserSitesAdminFactory;
use Zrcms\SwaggerExpressiveZrcms\Api\IsSwaggerRouteZrcms;
use Zrcms\SwaggerExpressiveZrcms\Api\IsSwaggerRouteZrcmsFactory;

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
                    IsAllowedSwagger::class => [
                        'factory' => IsAllowedSwaggerZrcmsRcmUserSitesAdminFactory::class,
                    ],
                    IsSwaggerRouteZrcms::class => [
                        'factory' => IsSwaggerRouteZrcmsFactory::class,
                    ],
                ],
            ],

            'swagger-expressive-is-swagger-route' => [
                IsSwaggerRouteZrcms::class => IsSwaggerRouteZrcms::class,
            ],
        ];
    }
}
