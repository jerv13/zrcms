<?php

namespace Zrcms\HttpApi;

use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use Zrcms\Acl\Api\IsAllowedRcmUser;
use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;
use Zrcms\Core\Api\Component\ComponentToArray;
use Zrcms\HttpApi\Acl\HttpApiIsAllowedFindBasicComponentIsAllowed;
use Zrcms\HttpApi\Acl\HttpApiIsAllowedReadAllComponentConfigsIsAllowed;
use Zrcms\HttpApi\Component\HttpApiFindComponent;
use Zrcms\HttpApi\Params\HttpApiParamQuery;
use Zrcms\HttpApi\Validate\HttpApiIdAttributeZfInputFilterServiceHttpApi;

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

                    HttpApiIsAllowedFindBasicComponentIsAllowed::class => [
                        'arguments' => [
                            IsAllowedRcmUserSitesAdmin::class,
                            ['literal' => []],
                            ['literal' => 'basic-repository-find-component'],
                        ],
                    ],

                    HttpApiIsAllowedReadAllComponentConfigsIsAllowed::class => [
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

                    HttpApiParamQuery::class => [],

                    /**
                     * Component ===========================================
                     */
                    HttpApiFindComponent::class => [
                        'arguments' => [
                            \Zrcms\Core\Api\Component\FindComponent::class,
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

                    HttpApiIdAttributeZfInputFilterServiceHttpApi::class => [
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
                ],
            ],
        ];
    }
}
