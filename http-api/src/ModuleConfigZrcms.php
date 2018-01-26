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
                            'api-service' => UpsertContentCmsResource::class,
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
                            'api-service' => InsertContentVersion::class,
                            'to-array' => ContentVersionToArray::class,
                            'not-found-status' => 404,
                        ],
                    ],
                ],
                */
            ],

            /**
             * ===== ZRCMS HTTP API Swagger =====
             */
            'zrcms-http-api-swagger' => [
                'swagger' => '2.0',
                'info' => [
                    'version' => '1.0.0',
                    'title' => 'ZRCMS',
                    'description' => 'ZRCMS APIs',
                    'contact' => ['name' => '',],
                    'license' => ['name' => '',],
                ],
                'host' => '',
                'basePath' => '/api',
                'schemes' => ['https',],
                'consumes' => ['application/json',],
                'produces' => ['application/json',],
                'paths' => [
                ],
                'definitions' => [
                    'Swagger' => [
                        'type' => 'object',
                        'properties' => [
                            'swagger' => [
                                'type' => 'string',
                                'format' => 'string',
                            ],
                            'info' => [
                                'type' => 'object',
                                'format' => 'object',
                            ],
                            'host' => [
                                'type' => 'string',
                                'format' => 'string',
                            ],
                            'basePath' => [
                                'type' => 'string',
                                'format' => 'string',
                            ],
                            'schemes' => [
                                'type' => 'array',
                                'format' => 'array',
                            ],
                            'consumes' => [
                                'type' => 'array',
                                'format' => 'array',
                            ],
                            'produces' => [
                                'type' => 'array',
                                'format' => 'array',
                            ],
                            'paths' => [
                                'type' => 'object',
                                'format' => 'object',
                            ],
                            'definitions' => [
                                'type' => 'object',
                                'format' => 'object',
                            ],
                        ],
                    ],
                    'ZrcmsJsonResponse' => [
                        'description' => 'ZrcmsJsonResponse',
                        'schema' => [
                            'type' => 'object',
                            'properties' => [
                                'data' => [
                                    'type' => 'object',
                                    'format' => 'string',
                                ],
                                'messages' => [
                                    'type' => 'array',
                                    'format' => 'array',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }
}
