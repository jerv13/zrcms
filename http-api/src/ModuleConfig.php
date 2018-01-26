<?php

namespace Zrcms\HttpApi;

use ZfInputFilterService\InputFilter\ServiceAwareFactory;
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
use Zrcms\HttpApi\CmsResource\HttpApiUpsertCmsResourceDynamic;
use Zrcms\HttpApi\CmsResource\HttpApiUpsertCmsResourceDynamicFactory;
use Zrcms\HttpApi\Component\HttpApiFindComponent;
use Zrcms\HttpApi\Component\HttpApiFindComponentFactory;
use Zrcms\HttpApi\Component\HttpApiFindComponentsBy;
use Zrcms\HttpApi\Component\HttpApiFindComponentsByFactory;
use Zrcms\HttpApi\Content\HttpApiFindContentVersionDynamic;
use Zrcms\HttpApi\Content\HttpApiFindContentVersionDynamicFactory;
use Zrcms\HttpApi\Content\HttpApiFindContentVersionsByDynamic;
use Zrcms\HttpApi\Content\HttpApiFindContentVersionsByDynamicFactory;
use Zrcms\HttpApi\Content\HttpApiInsertContentVersionDynamic;
use Zrcms\HttpApi\Content\HttpApiInsertContentVersionDynamicFactory;
use Zrcms\HttpApi\Dynamic\HttpApiDynamic;
use Zrcms\HttpApi\Dynamic\HttpApiDynamicFactory;
use Zrcms\HttpApi\Params\HttpApiLimit;
use Zrcms\HttpApi\Params\HttpApiOffset;
use Zrcms\HttpApi\Params\HttpApiOrderBy;
use Zrcms\HttpApi\Params\HttpApiOrderByFactory;
use Zrcms\HttpApi\Params\HttpApiWhere;
use Zrcms\HttpApi\Params\HttpApiWhereFactory;
use Zrcms\HttpApi\Response\ResponseMutatorJson;
use Zrcms\HttpApi\Response\ResponseMutatorJsonFactory;
use Zrcms\HttpApi\Validate\HttpApiIdAttributeZfInputFilterServiceHttpApi;
use Zrcms\HttpApi\Validate\HttpApiValidateFieldsDynamic;
use Zrcms\HttpApi\Validate\HttpApiValidateFieldsDynamicFactory;
use Zrcms\HttpApi\Validate\HttpApiValidateIdAttributeDynamic;
use Zrcms\HttpApi\Validate\HttpApiValidateIdAttributeDynamicFactory;
use Zrcms\HttpApi\Validate\HttpApiValidateWhereParamDynamic;
use Zrcms\HttpApi\Validate\HttpApiValidateWhereParamDynamicFactory;

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

                    HttpApiUpsertCmsResourceDynamic::class => [
                        'factory' => HttpApiUpsertCmsResourceDynamicFactory::class,
                    ],

                    /**
                     * Component ===========================================
                     */
                    HttpApiFindComponent::class => [
                        'factory' => HttpApiFindComponentFactory::class,
                    ],

                    HttpApiFindComponentsBy::class => [
                        'factory' => HttpApiFindComponentsByFactory::class,
                    ],

                    /**
                     * Content ===========================================
                     */
                    HttpApiFindContentVersionDynamic::class => [
                        'factory' => HttpApiFindContentVersionDynamicFactory::class,
                    ],

                    HttpApiFindContentVersionsByDynamic::class => [
                        'factory' => HttpApiFindContentVersionsByDynamicFactory::class,
                    ],

                    HttpApiInsertContentVersionDynamic::class => [
                        'factory' => HttpApiInsertContentVersionDynamicFactory::class,
                    ],

                    /**
                     * Dynamic ===========================================
                     */
                    HttpApiDynamic::class => [
                        'factory' => HttpApiDynamicFactory::class,
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

                    ResponseMutatorJson::class => [
                        'factory' => ResponseMutatorJsonFactory::class,
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

                    HttpApiValidateFieldsDynamic::class => [
                        'factory' => HttpApiValidateFieldsDynamicFactory::class,
                    ],

                    HttpApiValidateIdAttributeDynamic::class => [
                        'factory' => HttpApiValidateIdAttributeDynamicFactory::class,
                    ],

                    HttpApiValidateWhereParamDynamic::class => [
                        'factory' => HttpApiValidateWhereParamDynamicFactory::class,
                    ],

                    /**
                     * General ===========================================
                     */
                    GetDynamicApiConfig::class => [
                        'factory' => GetDynamicApiConfigAppConfigFactory::class,
                    ],
                ],
            ],

            /**
             * ===== ZRCMS HTTP API by request =====
             */
            'zrcms-http-api-dynamic' => [
                /* Example
                // '[{zrcms-implementation}][{zrcms-api}][{middleware-name}]=>[{middleware-config}]'
                '{zrcms-implementation}' => [
                    'find-cms-resource' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        'api' => [
                            'api-service' => FindSiteCmsResource::class,
                            'to-array' => CmsResourceToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],

                    'find-cms-resources-by' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        'api' => [
                            'api-service' => FindSiteCmsResourcesBy::class,
                            'to-array' => CmsResourcesToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],

                    'find-cms-resources-published' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        'api' => [
                            'api-service' => FindSiteCmsResourcesPublished::class,
                            'to-array' => CmsResourcesToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],

                    'upsert-cms-resource' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        'validate-fields' => [
                            'validate-fields' => ValidateFieldsByStrategy::class,
                            'validate-fields-options' => [
                                'field-validators' => [
                                    'id' => [
                                        'validator' => ValidateIsAnyValue::class,
                                        'options' => [],
                                    ],
                                    'published' => [
                                        'validator' => ValidateIsBoolean::class,
                                        'options' => [],
                                    ],
                                    'contentVersion' => [
                                        'validator' => ValidateFieldsByStrategy::class,
                                        'options' => [
                                            'field-validators' => [
                                                'id' => [
                                                    'validator' => ValidateIsAnyValue::class,
                                                    'options' => [],
                                                ],
                                                'properties' => [
                                                    'validator' => ValidateIsAssociativeArray::class,
                                                    'options' => [],
                                                ],
                                                'createdByUserId' => [
                                                    'validator' => ValidateIsNull::class,
                                                    'options' => [],
                                                ],
                                                'createdReason' => [
                                                    'validator' => ValidateCompositeByStrategy::class,
                                                    'options' => [
                                                        'validators' => [
                                                            [
                                                                'validator' => ValidateIsNotEmpty::class,
                                                            ],
                                                            [
                                                                'validator' => ValidateIsString::class,
                                                            ],
                                                        ]
                                                    ],
                                                ],
                                                'createdDate' => [
                                                    'validator' => ValidateIsNull::class,
                                                    'options' => [],
                                                ],
                                            ],
                                        ]
                                    ],
                                    'createdByUserId' => [
                                        'validator' => ValidateIsNull::class,
                                        'options' => [],
                                    ],
                                    'createdReason' => [
                                        'validator' => ValidateCompositeByStrategy::class,
                                        'options' => [
                                            'validators' => [
                                                [
                                                    'validator' => ValidateIsNotEmpty::class,
                                                ],
                                                [
                                                    'validator' => ValidateIsString::class,
                                                ],
                                            ]
                                        ],
                                    ],
                                    'createdDate' => [
                                        'validator' => ValidateIsNull::class,
                                        'options' => [],
                                    ],
                                ],
                            ],
                            'not-valid-status' => 400,
                        ],
                        'api' => [
                            'api-service' => UpsertSiteCmsResource::class,
                            'to-array' => CmsResourceToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],

                    'find-cms-resource-history' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        'api' => [
                            //'api-service' => TBD::class,
                            'to-array' => CmsResourceToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],

                    'find-cms-resource-histories-by' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        'api' => [
                            //'api-service' => TBD::class,
                            'to-array' => CmsResourcesToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],

                    'find-content-version' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        'api' => [
                            'api-service' => FindSiteVersion::class,
                            'to-array' => ContentVersionToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],

                    'find-content-versions-by' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        'api' => [
                            'api-service' => FindSiteVersionsBy::class,
                            'to-array' => ContentVersionsToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],

                    'insert-content-version' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        'validate-fields' => [
                            'validate-fields' => ValidateFieldsByStrategy::class,
                            'validate-fields-options' => [
                                'field-validators' => [
                                    'id' => [
                                        'validator' => ValidateIsAnyValue::class,
                                        'options' => [],
                                    ],
                                    'properties' => [
                                        'validator' => ValidateIsAssociativeArray::class,
                                        'options' => [],
                                    ],
                                    'createdByUserId' => [
                                        'validator' => ValidateIsNull::class,
                                        'options' => [],
                                    ],
                                    'createdReason' => [
                                        'validator' => ValidateCompositeByStrategy::class,
                                        'options' => [
                                            'validators' => [
                                                [
                                                    'validator' => ValidateIsNotEmpty::class,
                                                ],
                                                [
                                                    'validator' => ValidateIsString::class,
                                                ],
                                            ]
                                        ],
                                    ],
                                    'createdDate' => [
                                        'validator' => ValidateIsNull::class,
                                        'options' => [],
                                    ],
                                ],
                            ],
                            'not-valid-status' => 400,
                        ],
                        'api' => [
                            'api-service' => InsertSiteVersion::class,
                            'to-array' => ContentVersionToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],
                ],
                */
            ],
        ];
    }
}
