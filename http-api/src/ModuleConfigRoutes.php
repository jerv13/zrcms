<?php

namespace Zrcms\HttpApi;

use Zrcms\HttpApi\Acl\HttpApiIsAllowedDynamic;
use Zrcms\HttpApi\Acl\HttpApiIsAllowedFindComponent;
use Zrcms\HttpApi\CmsResource\HttpApiFindCmsResourceDynamic;
use Zrcms\HttpApi\CmsResource\HttpApiFindCmsResourcesByDynamic;
use Zrcms\HttpApi\Component\HttpApiFindComponent;
use Zrcms\HttpApi\Params\HttpApiParamQueryDynamic;
use Zrcms\HttpApi\Validate\HttpApiValidateIdAttributeDynamic;
use Zrcms\HttpApi\Validate\HttpApiValidateParamQueryDynamic;

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
                 * FindResource
                 *
                 * zrcms-implementation = site
                 * zrcms-api = http API service stack name
                 */
                'zrcms.api.cms-resource.{zrcms-implementation}.{id}' => [
                    'name' => 'zrcms.api.cms-resource.{zrcms-implementation}.{id}',
                    'path' => '/zrcms/api/cms-resource/{zrcms-implementation}/{id}',
                    'middleware' => [
                        'acl' => HttpApiIsAllowedDynamic::class,
                        'validate-id' => HttpApiValidateIdAttributeDynamic::class,
                        'api' => HttpApiFindCmsResourceDynamic::class,
                    ],
                    'options' => [
                        'zrcms-api' => 'find-cms-resource'
                    ],
                    'allowed_methods' => ['GET'],
                ],
                /**
                 * FindResourcesBy
                 *
                 * zrcms-implementation = site
                 * zrcms-api = http API service stack name
                 */
                'zrcms.api.cms-resource.{zrcms-implementation}.find-by' => [
                    'name' => 'zrcms.api.cms-resource.{zrcms-implementation}.find-by',
                    'path' => '/zrcms/api/cms-resource/{zrcms-implementation}/find-by',
                    'middleware' => [
                        'acl' => HttpApiIsAllowedDynamic::class,
                        'validate-param-query' => HttpApiValidateParamQueryDynamic::class,
                        'param-query' => HttpApiParamQueryDynamic::class,
                        'api' => HttpApiFindCmsResourcesByDynamic::class,
                    ],
                    'options' => [
                        'zrcms-api' => 'find-cms-resource'
                    ],
                    'allowed_methods' => ['GET'],
                ],

                //
                'zrcms.api.component.{type}.{name}' => [
                    'name' => 'zrcms.api.component.{type}.{name}',
                    'path' => '/zrcms/api/component/{type}/{name}',
                    'middleware' => [
                        'acl' => HttpApiIsAllowedFindComponent::class,
                        'api' => HttpApiFindComponent::class,
                    ],
                    'options' => [
                    ],
                    'allowed_methods' => ['GET'],
                ],
            ],
        ];
    }
}
