<?php

namespace Zrcms\HttpApi;

use Zrcms\HttpApi\Acl\HttpApiIsAllowedFindComponent;
use Zrcms\HttpApi\Component\HttpApiFindComponent;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigRoutes
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            'routes' => [

                'zrcms.api.{zrcms-name}.{id}' => [
                    'name' => 'zrcms.api.{zrcms-name}.{id}',
                    'path' => '/zrcms/api/{zrcms-name}/{id}',
                    'middleware' => [
                        'acl' => HttpApiIsAllowedFindComponent::class,
                        'api' => HttpApiFindComponent::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],

                'zrcms.api.find-component.{type}.{name}' => [
                    'name' => 'zrcms.api.find-component.{type}.{name}',
                    'path' => '/zrcms/api/find-component/{type}/{name}',
                    'middleware' => [
                        'acl' => HttpApiIsAllowedFindComponent::class,
                        'api' => HttpApiFindComponent::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
            ],
        ];
    }
}
