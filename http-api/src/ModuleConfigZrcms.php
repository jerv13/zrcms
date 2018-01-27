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
             * ===== HTTP API Swagger =====
             */
            'http-api-swagger' => [
                'definitions' => [
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
                'route-params' => [
                    'ZrcmsImplementationPathProperty' => [
                        'name' => 'zrcms-implementation',
                        'in' => 'path',
                        'description' => 'Implementation of core functionality name (I.E. site, page, etc..)',
                        'required' => true,
                        'type' => 'string',
                        'format' => 'string',
                    ],
                    'ZrcmsIdPathProperty' => [
                        'name' => 'id',
                        'in' => 'path',
                        'description' => 'ZRCMS ID field',
                        'required' => true,
                        'type' => 'string',
                        'format' => 'string',
                    ],
                    'ZrcmsWhereParameter' => [
                        'name' => 'where',
                        'in' => 'query',
                        'description' => 'Where filter param: ?where[{someField}]="{json-value}"',
                        'required' => false,
                        'type' => 'string',
                        'format' => 'json',
                    ],
                    'ZrcmsOrderByParameter' => [
                        'name' => 'orderby',
                        'in' => 'query',
                        'description' => 'Order by filter param: ?orderby[{someField}]="ASC"&orderby[{someOtherField}]="DESC", ',
                        'required' => false,
                        'type' => 'string',
                        'format' => 'string',
                    ],
                    'ZrcmsLimitParameter' => [
                        'name' => 'limit',
                        'in' => 'query',
                        'description' => 'Limit filter param: ?limit[{someField}]={int}',
                        'required' => false,
                        'type' => 'int',
                        'format' => 'int',
                    ],
                    'ZrcmsOffsetParameter' => [
                        'name' => 'offset',
                        'in' => 'query',
                        'description' => 'Offset filter param: ?offset[{someField}]={int}',
                        'required' => false,
                        'type' => 'int',
                        'format' => 'int',
                    ],
                    'ZrcmsComponentType' => [
                        'name' => 'zrcms-component-type',
                        'in' => 'path',
                        'description' => 'ZRCMS Component type field (basic, block, theme, etc..)',
                        'required' => true,
                        'type' => 'string',
                        'format' => 'string',
                    ],
                    'ZrcmsComponentName' => [
                        'name' => 'zrcms-component-name',
                        'in' => 'path',
                        'description' => 'ZRCMS Component name field (zrcms-language, zrcms-country, etc..)',
                        'required' => true,
                        'type' => 'string',
                        'format' => 'string',
                    ],
                ],
            ],
        ];
    }
}
