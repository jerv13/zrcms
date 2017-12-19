<?php

namespace Zrcms\HttpApi;

use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use Zrcms\Acl\Api\IsAllowedRcmUser;
use Zrcms\Core\Api\Component\ComponentToArray;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\HttpApi\Acl\IsAllowedFindBasicComponent;
use Zrcms\HttpApi\Acl\IsAllowedReadAllComponentConfigs;
use Zrcms\HttpApi\Component\FindComponentBasic;
use Zrcms\HttpApi\Component\ReadAllComponentConfigs;
use Zrcms\HttpApi\Params\ParamQuery;
use Zrcms\HttpApi\Validate\IdAttributeZfInputFilterService;

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
        ];
    }
}
