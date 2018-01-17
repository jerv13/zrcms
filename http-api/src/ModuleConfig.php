<?php

namespace Zrcms\HttpApi;

use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;
use Zrcms\Core\Api\CmsResource\CmsResourcesToArray;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\CmsResource\UpsertCmsResource;
use Zrcms\Core\Api\Component\ComponentToArray;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResource;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResourcesBy;
use Zrcms\HttpApi\Acl\HttpApiIsAllowedDynamic;
use Zrcms\HttpApi\Acl\HttpApiIsAllowedDynamicFactory;
use Zrcms\HttpApi\Acl\HttpApiIsAllowedFindComponent;
use Zrcms\HttpApi\Acl\HttpApiIsAllowedFindComponentFactory;
use Zrcms\HttpApi\CmsResource\HttpApiFindCmsResourceDynamic;
use Zrcms\HttpApi\CmsResource\HttpApiFindCmsResourceDynamicFactory;
use Zrcms\HttpApi\CmsResource\HttpApiFindCmsResourcesByDynamic;
use Zrcms\HttpApi\CmsResource\HttpApiFindCmsResourcesByDynamicFactory;
use Zrcms\HttpApi\CmsResource\HttpApiFindCmsResourcesPublishedDynamic;
use Zrcms\HttpApi\CmsResource\HttpApiFindCmsResourcesPublishedDynamicFactory;
use Zrcms\HttpApi\Component\HttpApiFindComponent;
use Zrcms\HttpApi\Params\HttpApiLimit;
use Zrcms\HttpApi\Params\HttpApiOffset;
use Zrcms\HttpApi\Params\HttpApiOrderBy;
use Zrcms\HttpApi\Params\HttpApiOrderByFactory;
use Zrcms\HttpApi\Params\HttpApiWhere;
use Zrcms\HttpApi\Params\HttpApiWhereFactory;
use Zrcms\HttpApi\Validate\HttpApiIdAttributeZfInputFilterServiceHttpApi;
use Zrcms\HttpApi\Validate\HttpApiValidateIdAttributeDynamic;
use Zrcms\HttpApi\Validate\HttpApiValidateIdAttributeDynamicFactory;
use Zrcms\HttpApi\Validate\HttpApiValidateWhereParamDynamic;
use Zrcms\HttpApi\Validate\HttpApiValidateWhereParamDynamicFactory;
use Zrcms\InputValidation\Api\Validate;
use Zrcms\InputValidation\Api\ValidateFieldsByStrategy;
use Zrcms\InputValidation\Api\ValidateIsAnyValue;
use Zrcms\InputValidation\Api\ValidateIsAssociativeArray;
use Zrcms\InputValidation\Api\ValidateIsBoolean;
use Zrcms\InputValidation\Api\ValidateIsNull;

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

                    HttpApiIsAllowedDynamic::class => [
                        'factory' => HttpApiIsAllowedDynamicFactory::class,
                    ],

                    HttpApiIsAllowedFindComponent::class => [
                        'factory' => HttpApiIsAllowedFindComponentFactory::class,
                    ],

                    /**
                     * CmsResource ===========================================
                     */
                    HttpApiFindCmsResourceDynamic::class => [
                        'factory' => HttpApiFindCmsResourceDynamicFactory::class,
                    ],

                    HttpApiFindCmsResourcesByDynamic::class => [
                        'factory' => HttpApiFindCmsResourcesByDynamicFactory::class,
                    ],

                    HttpApiFindCmsResourcesPublishedDynamic::class => [
                        'factory' => HttpApiFindCmsResourcesPublishedDynamicFactory::class,
                    ],

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
                     * Params ===========================================
                     */
                    HttpApiLimit::class => [],
                    HttpApiOffset::class => [],
                    HttpApiOrderBy::class => [
                        'factory' => HttpApiOrderByFactory::class,
                    ],
                    HttpApiWhere::class => [
                        'factory' => HttpApiWhereFactory::class,
                    ],

                    /**
                     * Validate ===========================================
                     */
                    HttpApiIdAttributeZfInputFilterServiceHttpApi::class => [
                        'arguments' => [
                            ServiceAwareFactory::class,
                            ['literal' => 'id'],
                        ],
                    ],

                    HttpApiValidateIdAttributeDynamic::class => [
                        'factory' => HttpApiValidateIdAttributeDynamicFactory::class,
                    ],

                    HttpApiValidateWhereParamDynamic::class => [
                        'factory' => HttpApiValidateWhereParamDynamicFactory::class,
                    ],

                    GetDynamicApiValue::class => [
                        'factory' => GetDynamicApiValueConfigFactory::class,
                    ],
                ],
            ],

            /**
             * ===== ZRCMS HTTP API by request =====
             */
            'zrcms-http-api-dynamic' => [
                // '[{zrcms-implementation}][{zrcms-api}][{middleware-name}]=>[{middleware-config}]'
                'site' => [
                    'find-cms-resource' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserSitesAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        /* @todo Is this needed
                         * 'validate-id' => [
                         * 'validate' => ValidateId::class,
                         * 'validate-options' => [],
                         * 'not-valid-status' => 400,
                         * ],
                         */
                        'api' => [
                            'api-service' => FindSiteCmsResource::class,
                            'to-array' => CmsResourceToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],

                    'find-cms-resources-by' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserSitesAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        'api' => [
                            'api-service' => FindSiteCmsResourcesBy::class,
                            'to-array' => CmsResourcesToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],

                    'upsert-cms-resource' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserSitesAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        'validate-data' => [
                            'validate-fields' => ValidateFieldsByStrategy::class,
                            'validate-fields-options' => [
                                'validation-config' => [
                                    'id' => [
                                        'validate-api' => ValidateIsAnyValue::class,
                                        'validate-api-options' => [],
                                    ],
                                    'published' => [
                                        'validate-api' => ValidateIsBoolean::class,
                                        'validate-api-options' => [],
                                    ],
                                    'contentVersion' => [
                                        'validate-api' => ValidateFieldsByStrategy::class,
                                        'validate-api-options' => [
                                            'validation-config' => [
                                                'id' => [
                                                    'validate-api' => ValidateIsAnyValue::class,
                                                    'validate-api-options' => [],
                                                ],
                                                'properties' => [
                                                    'validate-api' => ValidateIsAssociativeArray::class,
                                                    'validate-api-options' => [],
                                                ],
                                                'createdByUserId' => [
                                                    'validate-api' => ValidateIsNull::class,
                                                    'validate-api-options' => [],
                                                ],
                                                'createdReason' => [
                                                    'validate-api' => ValidateIsNull::class,
                                                    'validate-api-options' => [],
                                                ],
                                                'createdDate' => [
                                                    'validate-api' => ValidateIsNull::class,
                                                    'validate-api-options' => [],
                                                ],
                                            ],
                                        ]
                                    ],
                                    'createdByUserId' => [
                                        'validate-api' => ValidateIsNull::class,
                                        'validate-api-options' => [],
                                    ],
                                    'createdReason' => [
                                        'validate-api' => ValidateIsNull::class,
                                        'validate-api-options' => [],
                                    ],
                                    'createdDate' => [
                                        'validate-api' => ValidateIsNull::class,
                                        'validate-api-options' => [],
                                    ],
                                ],
                            ],
                            'not-valid-status' => 400,
                        ],
                        'api' => [
                            'api-service' => UpsertCmsResource::class,
                            'to-array' => CmsResourceToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],
                ],
            ],
        ];
    }
}
