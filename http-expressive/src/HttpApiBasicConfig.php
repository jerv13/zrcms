<?php

namespace Zrcms\HttpExpressive;

use Zrcms\Acl\Api\IsAllowedRcmUser;
use Zrcms\Content\Api\ComponentToArray;
use Zrcms\ContentCore\Basic\Api\Repository\FindBasicComponent;
use Zrcms\HttpExpressive\HttpApiBasic\Acl\IsAllowedFindBasicComponent;
use Zrcms\HttpExpressive\HttpApiBasic\Repository\FindComponentBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiBasicConfig
{
    /**
     * __invoke
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    /**
                     * Acl ===========================================
                     */
                    IsAllowedFindBasicComponent::class => [
                        'arguments' => [
                            IsAllowedRcmUser::class,
                            [
                                'literal' => [
                                    IsAllowedRcmUser::OPTION_RESOURCE_ID => 'sites',
                                    IsAllowedRcmUser::OPTION_PRIVILEGE => 'admin'
                                ]
                            ],
                            ['literal' => 'basic-repository-find-component'],
                        ],
                    ],
                    /**
                     * Repository ===========================================
                     */
                    FindComponentBasic::class => [
                        'arguments' => [
                            FindBasicComponent::class,
                            ComponentToArray::class,
                            ['literal' => 'basic']
                        ],
                    ],
                    /**
                     * Validate ===========================================
                     */
                ],
            ],
            'routes' => [
                // Find Component CmsResource
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
