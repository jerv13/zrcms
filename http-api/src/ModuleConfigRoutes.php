<?php

namespace Zrcms\HttpApi;

use Zrcms\HttpApi\Acl\HttpApiIsAllowedFindBasicComponentIsAllowed;
use Zrcms\HttpApi\Acl\HttpApiIsAllowedReadAllComponentConfigsIsAllowed;
use Zrcms\HttpApi\Component\HttpApiFindComponent;
use Zrcms\HttpApi\Component\HttpApiReadAllComponentConfigs;

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
                // @todo This is wrong
                'zrcms.read-all-component-configs' => [
                    'name' => 'zrcms.read-all-component-configs',
                    'path' => '/zrcms/read-all-component-configs',
                    'middleware' => [
                        'acl' => HttpApiIsAllowedReadAllComponentConfigsIsAllowed::class,
                        'api' => HttpApiReadAllComponentConfigs::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],

                'zrcms.basic.repository.find-component.type.name' => [
                    'name' => 'zrcms.basic.repository.find-component.type.name',
                    'path' => '/zrcms/basic/repository/find-component/{type}/{name}',
                    'middleware' => [
                        'acl' => HttpApiIsAllowedFindBasicComponentIsAllowed::class,
                        'api' => HttpApiFindComponent::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
            ],
        ];
    }
}
