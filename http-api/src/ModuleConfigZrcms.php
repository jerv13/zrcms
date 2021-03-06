<?php

namespace Zrcms\HttpApi;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigZrcms
{
    /**
     * @return array
     */
    public function __invoke()
    {
        return [
            /**
             * ===== ZRCMS HTTP API by request =====
             */
            'zrcms-http-api-dynamic' => [
                /* Example *
                // '[{zrcms-implementation}][{zrcms-api}][{middleware-name}]=>[{middleware-config}]'
                '{zrcms-implementation}' => [
                    'create-cms-resource' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        'fields-validator' => [
                            'fields-validator' => ValidateFieldsByStrategy::class,
                            'fields-validator-options' => [
                                'field-validators' => [
                                    'id' => [
                                        'validator' => ValidateIsString::class,
                                        'options' => [],
                                    ],
                                    'published' => [
                                        'validator' => ValidateIsBoolean::class,
                                        'options' => [],
                                    ],
                                    'contentVersionId' => [
                                        'validator' => ValidateIsString::class,
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
                            'api-service' => CreateContentCmsResource::class,
                            'to-array' => CmsResourceToArray::class,
                        ],
                    ],

                    'find-cms-resource' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        'api' => [
                            'api-service' => FindContentCmsResource::class,
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
                            'api-service' => FindContentCmsResourcesBy::class,
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
                            'api-service' => FindContentCmsResourcesPublished::class,
                            'to-array' => CmsResourcesToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],

                    'update-cms-resource' => [
                        'acl' => [
                            'is-allowed' => IsAllowedRcmUserAdmin::class,
                            'is-allowed-options' => [],
                            'not-allowed-status' => 401,
                        ],
                        'fields-validator' => [
                            'fields-validator' => ValidateFieldsByStrategy::class,
                            'fields-validator-options' => [
                                'field-validators' => [
                                    'id' => [
                                        'validator' => ValidateIsAnyValue::class,
                                        'options' => [],
                                    ],
                                    'published' => [
                                        'validator' => ValidateIsBoolean::class,
                                        'options' => [],
                                    ],
                                    'contentVersionId' => [
                                        'validator' => ValidateIsString::class,
                                    ],
                                    'modifiedByUserId' => [
                                        'validator' => ValidateIsNull::class,
                                        'options' => [],
                                    ],
                                    'modifiedReason' => [
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
                                    'modifiedDate' => [
                                        'validator' => ValidateIsNull::class,
                                        'options' => [],
                                    ],
                                ],
                            ],
                            'not-valid-status' => 400,
                        ],
                        'api' => [
                            'api-service-find-content-version' => FindContentVersion::class,
                            'api-service' => UpdateContentCmsResource::class,
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
                            'api-service' => FindContentVersion::class,
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
                            'api-service' => FindContentVersionsBy::class,
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
                        'fields-validator' => [
                            'fields-validator' => ValidateFieldsByStrategy::class,
                            'fields-validator-options' => [
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
                            'api-service' => InsertContentVersion::class,
                            'to-array' => ContentVersionToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],
                ],
                /* */
            ],
        ];
    }
}
