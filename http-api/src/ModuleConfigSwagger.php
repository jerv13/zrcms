<?php

namespace Zrcms\HttpApi;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfigSwagger
{
    public function __invoke()
    {
        return [
            /**
             * ===== HTTP API Swagger =====
             */
            'swagger-expressive' => [
                'definitions' => [
                    'ZrcmsCmsResource' => [
                        'description' => 'ZrcmsCmsResource',
                        'schema' => [
                            'type' => 'object',
                            'properties' => [
                                'id' => [
                                    'type' => 'string'
                                ],
                                'published' => [
                                    'type' => 'boolean'
                                ],
                                'contentVersion' => [
                                    '$ref' => '#/definitions/ZrcmsContentVersion/schema'
                                ],
                                'createdByUserId' => [
                                    'type' => 'string'
                                ],
                                'createdReason' => [
                                    'type' => 'string'
                                ],
                                'createdDate' => [
                                    'type' => 'string'
                                ],
                            ],
                        ],
                    ],
                    'ZrcmsCmsResourceHistory' => [
                        'description' => 'ZrcmsCmsResourceHistory',
                        'schema' => [
                            'type' => 'object',
                            'properties' => [
                                'id' => [
                                    'type' => 'string'
                                ],
                                'action' => [
                                    'type' => 'string'
                                ],
                                'cmsResourceId' => [
                                    'type' => 'string'
                                ],
                                'cmsResource' => [
                                    '$ref' => '#/definitions/ZrcmsCmsResource/schema'
                                ],
                                'contentVersionId' => [
                                    'type' => 'string'
                                ],
                                'contentVersion' => [
                                    '$ref' => '#/definitions/ZrcmsContentVersion/schema'
                                ],
                                'createdByUserId' => [
                                    'type' => 'string'
                                ],
                                'createdReason' => [
                                    'type' => 'string'
                                ],
                                'createdDate' => [
                                    'type' => 'string'
                                ],
                            ],
                        ],
                    ],
                    'ZrcmsComponent' => [
                        'description' => 'ZrcmsComponent',
                        'schema' => [
                            'type' => 'object',
                            'properties' => [
                                'type' => [
                                    'type' => 'string'
                                ],
                                'name' => [
                                    'type' => 'string'
                                ],
                                'configUri' => [
                                    'type' => 'string'
                                ],
                                'moduleDirectory' => [
                                    'type' => 'string'
                                ],
                                'properties' => [
                                    'type' => 'object'
                                ],
                                'createdByUserId' => [
                                    'type' => 'string'
                                ],
                                'createdReason' => [
                                    'type' => 'string'
                                ],
                                'createdDate' => [
                                    'type' => 'string'
                                ],
                            ],
                        ],
                    ],
                    'ZrcmsContentVersion' => [
                        'description' => 'ZrcmsContentVersion',
                        'schema' => [
                            'type' => 'object',
                            'properties' => [
                                'id' => [
                                    'type' => 'string'
                                ],
                                'properties' => [
                                    'type' => 'object'
                                ],
                                'createdByUserId' => [
                                    'type' => 'string'
                                ],
                                'createdReason' => [
                                    'type' => 'string'
                                ],
                                'createdDate' => [
                                    'type' => 'string'
                                ],
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
                    'ZrcmsJsonResponse:CmsResource' => [
                        'description' => 'ZrcmsJsonResponse:CmsResource',
                        'schema' => [
                            'type' => 'object',
                            'properties' => [
                                'data' => [
                                    '$ref' => '#/definitions/ZrcmsCmsResource/schema'
                                ],
                                'messages' => [
                                    'type' => 'array',
                                    'format' => 'array',
                                ],
                            ],
                        ],
                    ],
                    'ZrcmsJsonResponse:CmsResourceList' => [
                        'description' => 'ZrcmsJsonResponse:CmsResourceList',
                        'schema' => [
                            'type' => 'array',
                            'items' => [
                                '$ref' => '#/definitions/ZrcmsCmsResource/schema'
                            ],
                        ],
                    ],
                    'ZrcmsJsonResponse:CmsResourceHistory' => [
                        'description' => 'ZrcmsJsonResponse:CmsResourceHistory',
                        'schema' => [
                            'type' => 'object',
                            'properties' => [
                                'data' => [
                                    '$ref' => '#/definitions/ZrcmsCmsResourceHistory/schema'
                                ],
                                'messages' => [
                                    'type' => 'array',
                                    'format' => 'array',
                                ],
                            ],
                        ],
                    ],
                    'ZrcmsJsonResponse:CmsResourceHistoryList' => [
                        'description' => 'ZrcmsJsonResponse:CmsResourceHistoryList',
                        'schema' => [
                            'type' => 'array',
                            'items' => [
                                '$ref' => '#/definitions/ZrcmsCmsResourceHistory/schema'
                            ],
                        ],
                    ],
                    'ZrcmsJsonResponse:Component' => [
                        'description' => 'ZrcmsJsonResponse:Component',
                        'schema' => [
                            'type' => 'object',
                            'properties' => [
                                'data' => [
                                    '$ref' => '#/definitions/ZrcmsComponent/schema'
                                ],
                                'messages' => [
                                    'type' => 'array',
                                    'format' => 'array',
                                ],
                            ],
                        ],
                    ],
                    'ZrcmsJsonResponse:ComponentList' => [
                        'description' => 'ZrcmsJsonResponse:ComponentList',
                        'schema' => [
                            'type' => 'array',
                            'items' => [
                                '$ref' => '#/definitions/ZrcmsComponent/schema'
                            ],
                        ],
                    ],
                    'ZrcmsJsonResponse:ContentVersion' => [
                        'description' => 'ZrcmsJsonResponse:ContentVersion',
                        'schema' => [
                            'type' => 'object',
                            'properties' => [
                                'data' => [
                                    '$ref' => '#/definitions/ZrcmsContentVersion/schema'
                                ],
                                'messages' => [
                                    'type' => 'array',
                                    'format' => 'array',
                                ],
                            ],
                        ],
                    ],
                    'ZrcmsJsonResponse:ContentVersionList' => [
                        'description' => 'ZrcmsJsonResponse:ContentVersionList',
                        'schema' => [
                            'type' => 'array',
                            'items' => [
                                '$ref' => '#/definitions/ZrcmsContentVersion/schema'
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
