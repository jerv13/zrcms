<?php

namespace Zrcms\HttpApiSwagger;

use Zrcms\HttpApiSwagger\Api\HttpApiIsAllowedSwagger;
use Zrcms\HttpApiSwagger\Api\HttpApiIsAllowedSwaggerFactory;
use Zrcms\HttpApiSwagger\Api\HttpApiSwagger;
use Zrcms\HttpApiSwagger\Api\HttpApiSwaggerFactory;

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
                    HttpApiIsAllowedSwagger::class => [
                        'factory' => HttpApiIsAllowedSwaggerFactory::class,
                    ],

                    HttpApiSwagger::class => [
                        'factory' => HttpApiSwaggerFactory::class,
                    ],
                ],
            ],
        ];
    }
}
