<?php

namespace Zrcms\HttpCore;

use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use Zrcms\Acl\Api\IsAllowedRcmUser;
use Zrcms\Core\Api\Component\ComponentToArray;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\HttpCore\Acl\IsAllowedFindBasicComponent;
use Zrcms\HttpCore\Acl\IsAllowedReadAllComponentConfigs;
use Zrcms\HttpCore\Component\FindComponentBasic;
use Zrcms\HttpCore\Component\ReadAllComponentConfigs;
use Zrcms\HttpCore\Params\ParamQuery;
use Zrcms\HttpCore\Validate\IdAttributeZfInputFilterService;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
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

                    /** ACL EXAMPLE *
                     * IsAllowedCheckApi::class => [
                     * 'arguments' => [
                     * IsAllowedRcmUser::class,
                     * [
                     * 'literal' => [
                     * IsAllowedRcmUser::OPTION_RESOURCE_ID => 'admin',
                     * IsAllowedRcmUser::OPTION_PRIVILEGE => 'read'
                     * ]
                     * ],
                     *
                     * ],
                     * ],
                     * /* */

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

                    IsAllowedReadAllComponentConfigs::class => [
                        'arguments' => [
                            IsAllowedRcmUser::class,
                            [
                                'literal' => [
                                    IsAllowedRcmUser::OPTION_RESOURCE_ID => 'admin',
                                    IsAllowedRcmUser::OPTION_PRIVILEGE => 'read'
                                ]
                            ],
                            ['literal' => 'get-register-components']
                        ],
                    ],

                    /**
                     * Params ===========================================
                     */

                    ParamQuery::class => [],

                    /**
                     * Component ===========================================
                     */
                    FindComponentBasic::class => [
                        'arguments' => [
                            FindComponent::class,
                            ComponentToArray::class,
                            ['literal' => 'basic']
                        ],
                    ],
                    /**
                     * Validate ===========================================
                     */
                    /** Attribute Validator EXAMPLE *
                     * AttributesZfInputFilterService::class => [
                     * 'arguments' => [
                     * ServiceAwareFactory::class,
                     * [
                     * 'literal' => [
                     * // zf-input-filter-service config
                     * 'test1' => [
                     * 'name' => 'test1',
                     * 'required' => true,
                     * 'validators' => [
                     * [
                     * // Invoked
                     * 'name' => 'ZfInputFilterService\Validator\Test',
                     * 'options' => [
                     * 'test' => 'validatorOptionInvoked',
                     * 'messages' => [
                     * 'TEST' => 'validatorMessageTemplateInvoked',
                     * ],
                     * ],
                     * ],
                     * [
                     * // Service
                     * 'name' => 'ZfInputFilterService\Validator\TestService',
                     * 'service' => true,
                     * 'options' => [
                     * 'test' => 'validatorOptionService',
                     * 'messages' => [
                     * 'TEST' => 'validatorMessageTemplateService',
                     * ],
                     * ],
                     * ],
                     * ],
                     * ],
                     * ]
                     * ],
                     * ],
                     * ],
                     * /* */

                    IdAttributeZfInputFilterService::class => [
                        'arguments' => [
                            ServiceAwareFactory::class,
                            ['literal' => 'id'],
                        ],
                    ],

                    /** Data Validator EXAMPLE *
                     * DataZfInputFilterService::class => [
                     * 'arguments' => [
                     * ServiceAwareFactory::class,
                     * [
                     * 'literal' => [
                     * // zf-input-filter-service config
                     * 'test1' => [
                     * 'name' => 'test1',
                     * 'required' => true,
                     * 'validators' => [
                     * [
                     * // Invoked
                     * 'name' => 'ZfInputFilterService\Validator\Test',
                     * 'options' => [
                     * 'test' => 'validatorOptionInvoked',
                     * 'messages' => [
                     * 'TEST' => 'validatorMessageTemplateInvoked',
                     * ],
                     * ],
                     * ],
                     * [
                     * // Service
                     * 'name' => 'ZfInputFilterService\Validator\TestService',
                     * 'service' => true,
                     * 'options' => [
                     * 'test' => 'validatorOptionService',
                     * 'messages' => [
                     * 'TEST' => 'validatorMessageTemplateService',
                     * ],
                     * ],
                     * ],
                     * ],
                     * ],
                     * ]
                     * ],
                     * ],
                     * ],
                     * /* */

                    /**
                     * general ===========================================
                     */

                    ReadAllComponentConfigs::class => [
                        'arguments' => [
                            \Zrcms\Core\Api\Component\ReadAllComponentConfigsBasic::class,
                        ],
                    ],
                ],
            ],

            'routes' => [
                // Find Component CmsResource
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
