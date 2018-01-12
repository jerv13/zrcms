<?php

namespace Zrcms\HttpApi;

use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use Zrcms\Acl\Api\IsAllowed;
use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;
use Zrcms\Core\Api\CmsResource\FindCmsResource;
use Zrcms\Core\Api\CmsResource\FindCmsResourcesBy;
use Zrcms\Core\Api\CmsResource\FindCmsResourcesPublished;
use Zrcms\Core\Api\Component\ComponentToArray;
use Zrcms\Debug\IsDebug;
use Zrcms\HttpApi\Acl\HttpApiIsAllowedFindComponent;
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

                    HttpApiIsAllowedFindComponent::class => [
                        'arguments' => [
                            IsAllowedRcmUserSitesAdmin::class,
                            ['literal' => []],
                            ['literal' => 'basic-repository-find-component'],
                            ['literal' => 401],
                            ['literal' => IsDebug::invoke()],
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

                    GetDynamicApiValue::class => [
                        'factory' => GetDynamicApiValueConfigFactory::class,
                    ],
                ],
            ],

            /**
             * ===== ZRCMS HTTP API Types =====
             */
            'zrcms-http-api' => [
                '{zrcms-name}' => [
                    'http-api-find-cms-resource' => [
                        'acl' => [
                            'isAllowed' => IsAllowed::class,
                            'isAllowedOptions' => [],
                            'notAllowedStatus' => 401,
                        ],
                        'validator-attributes' => '',
                        'api' => FindCmsResource::class,
                    ],
                    'http-api-find-cms-resources-by' => [
                        'acl' => [
                            'isAllowed' => IsAllowed::class,
                            'isAllowedOptions' => [],
                            'notAllowedStatus' => 401,
                        ],
                        'api' => FindCmsResourcesBy::class,
                    ],
                    'http-api-find-cms-resources-published' => [
                        'acl' => [
                            'isAllowed' => IsAllowed::class,
                            'isAllowedOptions' => [],
                            'notAllowedStatus' => 401,
                        ],
                        'api' => FindCmsResourcesPublished::class,
                    ],
                    'http-api-upsert-cms-resource' => [
                        'acl' => [
                            'isAllowed' => IsAllowed::class,
                            'isAllowedOptions' => [],
                            'notAllowedStatus' => 401,
                        ],
                        'validator-data' => [

                        ],
                        'api' => FindCmsResourcesPublished::class,
                    ],
                ],
            ],
        ];
    }
}
