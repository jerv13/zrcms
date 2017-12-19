<?php

namespace Zrcms\HttpApi;

use Zrcms\HttpApi\Acl\IsAllowedFindBasicComponent;
use Zrcms\HttpApi\Acl\IsAllowedReadAllComponentConfigs;
use Zrcms\HttpApi\Component\FindComponentBasic;
use Zrcms\HttpApi\Component\ReadAllComponentConfigs;

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
                        'acl' => IsAllowedReadAllComponentConfigs::class,
                        'api' => ReadAllComponentConfigs::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],

                //  @todo This is wrong
                'zrcms.basic.repository.find-component.name' => [
                    'name' => 'zrcms.basic.repository.find-component.name',
                    'path' => '/zrcms/basic/repository/find-component/{name}',
                    'middleware' => [
                        'acl' => IsAllowedFindBasicComponent::class,
                        'api' => FindComponentBasic::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
            ],
        ];
    }
}
