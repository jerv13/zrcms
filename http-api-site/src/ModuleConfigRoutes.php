<?php

namespace Zrcms\HttpApiSite;

use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;
use Zrcms\Core\Api\CmsResource\CmsResourcesToArray;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\Content\ContentVersionsToArray;
use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResource;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResourcesBy;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResourcesPublished;
use Zrcms\CoreSite\Api\CmsResource\UpsertSiteCmsResource;
use Zrcms\CoreSite\Api\Content\FindSiteVersion;
use Zrcms\CoreSite\Api\Content\FindSiteVersionsBy;
use Zrcms\CoreSite\Api\Content\InsertSiteVersion;

/**
 * @author James Jervis - https:/github.com/jerv13
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
//                'zrcms.site.cms-resource' => [
//                    'name' => 'zrcms.site.cms-resource',
//                    'path' => '/zrcms/site/cms-resource',
//                    'middleware' => [
//                        'parser' => BodyParamsMiddleware::class,
//                        'acl' => HttpApiIsAllowedSitePublishIsAllowed::class,
//                        'validator-data' => HttpApiUpsertSiteCmsResourceZfInputFilterServiceHttpApi::class,
//                        'api' => UpsertSiteCmsResource::class,
//                    ],
//                    'options' => [],
//                    'allowed_methods' => ['PUT'],
//                ],
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

                    'find-cms-resources-published' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserSitesAdmin::class,
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
                            'is-allowed' => IsAllowedRcmUserSitesAdmin::class,
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
                            'is-allowed' => IsAllowedRcmUserSitesAdmin::class,
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
                            'is-allowed' => IsAllowedRcmUserSitesAdmin::class,
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
                            'is-allowed' => IsAllowedRcmUserSitesAdmin::class,
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
                            'is-allowed' => IsAllowedRcmUserSitesAdmin::class,
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
                            'is-allowed' => IsAllowedRcmUserSitesAdmin::class,
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
            ],
        ];
    }
}
