<?php

namespace Zrcms\HttpCore;

use Zrcms\HttpCore\Acl\IsAllowedFindBasicComponent;
use Zrcms\HttpCore\Acl\IsAllowedReadAllComponentConfigs;
use Zrcms\HttpCore\Component\FindComponentBasic;
use Zrcms\HttpCore\Component\ReadAllComponentConfigs;

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
