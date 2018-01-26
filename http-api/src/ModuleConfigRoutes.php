<?php

namespace Zrcms\HttpApi;

use Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware;
use Zrcms\HttpApi\Acl\HttpApiIsAllowedDynamic;
use Zrcms\HttpApi\Acl\HttpApiIsAllowedFindComponent;
use Zrcms\HttpApi\CmsResource\HttpApiFindCmsResourceDynamic;
use Zrcms\HttpApi\CmsResource\HttpApiFindCmsResourcesByDynamic;
use Zrcms\HttpApi\CmsResource\HttpApiFindCmsResourcesPublishedDynamic;
use Zrcms\HttpApi\CmsResource\HttpApiUpsertCmsResourceDynamic;
use Zrcms\HttpApi\CmsResourceHistory\HttpApiFindCmsResourceHistoryByDynamic;
use Zrcms\HttpApi\CmsResourceHistory\HttpApiFindCmsResourceHistoryDynamic;
use Zrcms\HttpApi\Component\HttpApiFindComponent;
use Zrcms\HttpApi\Component\HttpApiFindComponentsBy;
use Zrcms\HttpApi\Content\HttpApiFindContentVersionDynamic;
use Zrcms\HttpApi\Content\HttpApiFindContentVersionsByDynamic;
use Zrcms\HttpApi\Content\HttpApiInsertContentVersionDynamic;
use Zrcms\HttpApi\Dynamic\HttpApiDynamic;
use Zrcms\HttpApi\Params\HttpApiLimit;
use Zrcms\HttpApi\Params\HttpApiOffset;
use Zrcms\HttpApi\Params\HttpApiOrderBy;
use Zrcms\HttpApi\Params\HttpApiWhere;
use Zrcms\HttpApi\Swagger\HttpApiIsAllowedSwagger;
use Zrcms\HttpApi\Swagger\HttpApiSwagger;
use Zrcms\HttpApi\Validate\HttpApiValidateFieldsDynamic;
use Zrcms\HttpApi\ZrcmsConfig\HttpApiIsAllowedZrcmsConfig;
use Zrcms\HttpApi\ZrcmsConfig\HttpApiZrcmsConfig;
use Zrcms\HttpApi\ZrcmsConfig\HttpApiZrcmsRoutes;

/**
 * @author James Jervis - https://github.com/jerv13
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
                /**
                 * FindCmsResource find-cms-resource
                 */
                'zrcms.api.cms-resource.{zrcms-implementation}.find.{id}' => [
                    'name' => 'zrcms.api.cms-resource.{zrcms-implementation}.find.{id}',
                    'path' => '/zrcms/api/cms-resource/{zrcms-implementation}/find/{id}',
                    'middleware' => [
                        'dynamic' => HttpApiDynamic::class,
                        'acl' => HttpApiIsAllowedDynamic::class,
                        // @todo 'validate-id' => HttpApiValidateIdAttributeDynamic::class,
                        'api' => HttpApiFindCmsResourceDynamic::class,
                    ],
                    'options' => [
                        'zrcms-api' => 'find-cms-resource'
                    ],
                    'allowed_methods' => ['GET'],
                    'swagger' => [
                        'get' => [
                            'description' => 'Find CMS Resource by ID',
                            'produces' => [
                                'application/json',
                            ],
                            'parameters' => [
                                [
                                    'name' => 'zrcms-implementation',
                                    'in' => 'path',
                                    'description' => 'Implementation of CmsResource',
                                    'required' => true,
                                    'type' => 'string',
                                    'format' => 'string',
                                ],
                                [
                                    'name' => 'id',
                                    'in' => 'path',
                                    'description' => 'Id of CmsResource',
                                    'required' => true,
                                    'type' => 'string',
                                    'format' => 'string',
                                ]
                            ],
                            'responses' => [
                                'default' => [
                                    '$ref' => '#/definitions/ZrcmsJsonResponse'
                                ],
                            ],
                        ],
                    ],
                ],

                /**
                 * FindCmsResourcesBy find-cms-resources-by
                 */
                'zrcms.api.cms-resources.{zrcms-implementation}.find-by' => [
                    'name' => 'zrcms.api.cms-resources.{zrcms-implementation}.find-by',
                    'path' => '/zrcms/api/cms-resources/{zrcms-implementation}/find-by',
                    'middleware' => [
                        'dynamic' => HttpApiDynamic::class,
                        'acl' => HttpApiIsAllowedDynamic::class,
                        'param-limit' => HttpApiLimit::class,
                        'param-offset' => HttpApiOffset::class,
                        'param-order-by' => HttpApiOrderBy::class,
                        //'validate-param-order-by' => XXX::class,
                        'param-where' => HttpApiWhere::class,
                        //'validate-param-where' => XXX::class,
                        'api' => HttpApiFindCmsResourcesByDynamic::class,
                    ],
                    'options' => [
                        'zrcms-api' => 'find-cms-resources-by'
                    ],
                    'allowed_methods' => ['GET'],
                ],

                /**
                 * FindCmsResourcesPublished find-cms-resources-published
                 */
                'zrcms.api.cms-resources.{zrcms-implementation}.find-published' => [
                    'name' => 'zrcms.api.cms-resources.{zrcms-implementation}.find-published',
                    'path' => '/zrcms/api/cms-resources/{zrcms-implementation}/find-published',
                    'middleware' => [
                        'dynamic' => HttpApiDynamic::class,
                        'acl' => HttpApiIsAllowedDynamic::class,
                        'param-limit' => HttpApiLimit::class,
                        'param-offset' => HttpApiOffset::class,
                        'param-order-by' => HttpApiOrderBy::class,
                        //'validate-param-order-by' => XXX::class,
                        'param-where' => HttpApiWhere::class,
                        //'validate-param-where' => XXX::class,
                        'api' => HttpApiFindCmsResourcesPublishedDynamic::class,
                    ],
                    'options' => [
                        'zrcms-api' => 'find-cms-resources-published'
                    ],
                    'allowed_methods' => ['GET'],
                ],

                /**
                 * UpsertCmsResource upsert-cms-resource
                 */
                'zrcms.api.cms-resource.{zrcms-implementation}.upsert' => [
                    'name' => 'zrcms.api.cms-resource.{zrcms-implementation}.upsert',
                    'path' => '/zrcms/api/cms-resource/{zrcms-implementation}/upsert',
                    'middleware' => [
                        'dynamic' => HttpApiDynamic::class,
                        'acl' => HttpApiIsAllowedDynamic::class,
                        'body-parser' => BodyParamsMiddleware::class,
                        'validate-fields' => HttpApiValidateFieldsDynamic::class,
                        'api' => HttpApiUpsertCmsResourceDynamic::class,
                    ],
                    'options' => [
                        'zrcms-api' => 'upsert-cms-resource'
                    ],
                    'allowed_methods' => ['POST', 'PUT'],
                ],

                /**
                 * FindCmsResourceHistory find-cms-resource-history
                 */
                'zrcms.api.cms-resource-history.{zrcms-implementation}.find.{id}' => [
                    'name' => 'zrcms.api.cms-resource-history.{zrcms-implementation}.find.{id}',
                    'path' => '/zrcms/api/cms-resource-history/{zrcms-implementation}/find/{id}',
                    'middleware' => [
                        'dynamic' => HttpApiDynamic::class,
                        'acl' => HttpApiIsAllowedDynamic::class,
                        // @todo 'validate-id' => HttpApiValidateIdAttributeDynamic::class,
                        'api' => HttpApiFindCmsResourceHistoryDynamic::class,
                    ],
                    'options' => [
                        'zrcms-api' => 'find-cms-resource-history'
                    ],
                    'allowed_methods' => ['GET'],
                ],

                /**
                 * FindCmsResourceHistoryBy find-cms-resources-by-histories
                 */
                'zrcms.api.cms-resource-histories.{zrcms-implementation}.find-by' => [
                    'name' => 'zrcms.api.cms-resource-histories.{zrcms-implementation}.find-by',
                    'path' => '/zrcms/api/cms-resource-histories/{zrcms-implementation}/find-by',
                    'middleware' => [
                        'dynamic' => HttpApiDynamic::class,
                        'acl' => HttpApiIsAllowedDynamic::class,
                        'param-limit' => HttpApiLimit::class,
                        'param-offset' => HttpApiOffset::class,
                        'param-order-by' => HttpApiOrderBy::class,
                        //'validate-param-order-by' => XXX::class,
                        'param-where' => HttpApiWhere::class,
                        //'validate-param-where' => XXX::class,
                        'api' => HttpApiFindCmsResourceHistoryByDynamic::class,
                    ],
                    'options' => [
                        'zrcms-api' => 'find-cms-resources-by-histories'
                    ],
                    'allowed_methods' => ['GET'],
                ],

                /**
                 * FindConfig
                 */
                'zrcms.api.config.list' => [
                    'name' => 'zrcms.api.config.list',
                    'path' => '/zrcms/api/config/list',
                    'middleware' => [
                        'acl' => HttpApiIsAllowedZrcmsConfig::class,
                        'api' => HttpApiZrcmsConfig::class,
                    ],
                    'options' => [
                    ],
                    'allowed_methods' => ['GET'],
                ],

                'zrcms.api.route.list' => [
                    'name' => 'zrcms.api.route.list',
                    'path' => '/zrcms/api/route/list',
                    'middleware' => [
                        'acl' => HttpApiIsAllowedZrcmsConfig::class,
                        'api' => HttpApiZrcmsRoutes::class,
                    ],
                    'options' => [
                    ],
                    'allowed_methods' => ['GET'],
                ],

                /**
                 * Swagger
                 */
                'zrcms.api.swagger.json' => [
                    'name' => 'zrcms.api.swagger.json',
                    'path' => '/zrcms/api/swagger.json',
                    'middleware' => [
                        'acl' => HttpApiIsAllowedSwagger::class,
                        'api' => HttpApiSwagger::class,
                    ],
                    'options' => [
                    ],
                    'swagger' => [
                        'get' => [
                            'description' => 'Produces Swagger JSON',
                            //'operationId' => 'zrcms.api.swagger.json',
                            'produces' => [
                                'application/json',
                            ],
                            'parameters' => [
                                /* EXAMPLE
                                [
                                    'name' => 'limit',
                                    'in' => 'query',
                                    'description' => 'maximum number of results to return',
                                    'required' => false,
                                    'type' => 'integer',
                                    'format' => 'int32',
                                ]
                                */
                            ],
                            'responses' => [
                                200 => [
                                    'description' => 'swagger object response',
                                    'schema' => [
                                        'type' => 'object',
                                        'items' => ['$ref' => '#/definitions/Swagger',],
                                    ],
                                ],
                                /*
                                'default' => [
                                    'description' => 'unexpected error',
                                    'schema' => ['$ref' => '#/definitions/ErrorModel',],
                                ],
                                 */
                            ],
                        ],
                    ],
                    'allowed_methods' => ['GET'],
                ],

                /**
                 * FindComponent
                 */
                'zrcms.api.component.{type}.find.{name}' => [
                    'name' => 'zrcms.api.component.{type}.find.{name}',
                    'path' => '/zrcms/api/component/{type}/find/{name}',
                    'middleware' => [
                        'acl' => HttpApiIsAllowedFindComponent::class,
                        'api' => HttpApiFindComponent::class,
                    ],
                    'options' => [
                    ],
                    'allowed_methods' => ['GET'],
                ],

                /**
                 * FindComponentsBy
                 */
                'zrcms.api.components.find-by' => [
                    'name' => 'zrcms.api.components.find-by',
                    'path' => '/zrcms/api/components/find-by',
                    'middleware' => [
                        'acl' => HttpApiIsAllowedFindComponent::class,
                        'param-limit' => HttpApiLimit::class,
                        'param-offset' => HttpApiOffset::class,
                        'param-order-by' => HttpApiOrderBy::class,
                        //'validate-param-order-by' => XXX::class,
                        'param-where' => HttpApiWhere::class,
                        //'validate-param-where' => XXX::class,
                        'api' => HttpApiFindComponentsBy::class,
                    ],
                    'options' => [
                    ],
                    'allowed_methods' => ['GET'],
                ],

                /**
                 * FindContentVersion find-content-version
                 */
                'zrcms.api.content-version.{zrcms-implementation}.find.{id}' => [
                    'name' => 'zrcms.api.content-version.{zrcms-implementation}.find.{id}',
                    'path' => '/zrcms/api/content-version/{zrcms-implementation}/find/{id}',
                    'middleware' => [
                        'dynamic' => HttpApiDynamic::class,
                        'acl' => HttpApiIsAllowedDynamic::class,
                        // @todo 'validate-id' => HttpApiValidateIdAttributeDynamic::class,
                        'api' => HttpApiFindContentVersionDynamic::class,
                    ],
                    'options' => [
                        'zrcms-api' => 'find-content-version'
                    ],
                    'allowed_methods' => ['GET'],
                ],

                /**
                 * FindContentVersionsBy find-content-versions-by
                 */
                'zrcms.api.content-versions.{zrcms-implementation}.find-by' => [
                    'name' => 'zrcms.api.content-versions.{zrcms-implementation}.find-by',
                    'path' => '/zrcms/api/content-versions/{zrcms-implementation}/find-by',
                    'middleware' => [
                        'dynamic' => HttpApiDynamic::class,
                        'acl' => HttpApiIsAllowedDynamic::class,
                        'param-limit' => HttpApiLimit::class,
                        'param-offset' => HttpApiOffset::class,
                        'param-order-by' => HttpApiOrderBy::class,
                        //'validate-param-order-by' => XXX::class,
                        'param-where' => HttpApiWhere::class,
                        //'validate-param-where' => XXX::class,
                        'api' => HttpApiFindContentVersionsByDynamic::class,
                    ],
                    'options' => [
                        'zrcms-api' => 'find-content-versions-by'
                    ],
                    'allowed_methods' => ['GET'],
                ],

                /**
                 * InsertContentVersion insert-content-version
                 */
                'zrcms.api.content-version.{zrcms-implementation}.insert' => [
                    'name' => 'zrcms.api.content-version.{zrcms-implementation}.insert',
                    'path' => '/zrcms/api/content-version/{zrcms-implementation}/insert',
                    'middleware' => [
                        'dynamic' => HttpApiDynamic::class,
                        'acl' => HttpApiIsAllowedDynamic::class,
                        'body-parser' => BodyParamsMiddleware::class,
                        'validate-fields' => HttpApiValidateFieldsDynamic::class,
                        'api' => HttpApiInsertContentVersionDynamic::class,
                    ],
                    'options' => [
                        'zrcms-api' => 'insert-content-version'
                    ],
                    'allowed_methods' => ['POST'],
                ],
            ],
        ];
    }
}
