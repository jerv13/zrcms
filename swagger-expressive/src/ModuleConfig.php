<?php

namespace Zrcms\SwaggerExpressive;

use Zrcms\SwaggerExpressive\Api\IsAllowedSwagger;
use Zrcms\SwaggerExpressive\Api\IsAllowedSwaggerAnyFactory;
use Zrcms\SwaggerExpressive\Api\IsSwaggerRoute;
use Zrcms\SwaggerExpressive\Api\IsSwaggerRouteCompositeFactory;
use Zrcms\SwaggerExpressive\Api\IsSwaggerRouteSwaggerKey;
use Zrcms\SwaggerExpressive\Api\IsSwaggerRouteSwaggerKeyFactory;
use Zrcms\SwaggerExpressive\Middleware\HttpApiIsAllowedSwagger;
use Zrcms\SwaggerExpressive\Middleware\HttpApiIsAllowedSwaggerFactory;
use Zrcms\SwaggerExpressive\Middleware\HttpApiSwagger;
use Zrcms\SwaggerExpressive\Middleware\HttpApiSwaggerFactory;

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
                        // Over-ride this
                        'factory' => IsAllowedSwaggerAnyFactory::class,
                    ],
                    IsSwaggerRoute::class => [
                        'factory' => IsSwaggerRouteCompositeFactory::class,
                    ],
                    IsSwaggerRouteSwaggerKey::class => [
                        'factory' => IsSwaggerRouteSwaggerKeyFactory::class,
                    ],

                    HttpApiIsAllowedSwagger::class => [
                        'factory' => HttpApiIsAllowedSwaggerFactory::class,
                    ],
                    HttpApiSwagger::class => [
                        'factory' => HttpApiSwaggerFactory::class,
                    ],
                ],
            ],

            'swagger-expressive-is-swagger-route' => [
                IsSwaggerRouteSwaggerKey::class => IsSwaggerRouteSwaggerKey::class,
            ],
        ];
    }
}
