<?php

namespace Zrcms\HttpApi;

use ZfInputFilterService\InputFilter\ServiceAwareFactory;
use Zrcms\Acl\Api\IsAllowed;
use Zrcms\Acl\Api\IsAllowedRcmUserSitesAdmin;
use Zrcms\Core\Api\CmsResource\CmsResourceToArray;
use Zrcms\Core\Api\CmsResource\FindCmsResource;
use Zrcms\Core\Api\Component\ComponentToArray;
use Zrcms\CoreSite\Api\CmsResource\FindSiteCmsResource;
use Zrcms\HttpApi\Acl\HttpApiIsAllowedDynamic;
use Zrcms\HttpApi\Acl\HttpApiIsAllowedDynamicFactory;
use Zrcms\HttpApi\Acl\HttpApiIsAllowedFindComponent;
use Zrcms\HttpApi\Acl\HttpApiIsAllowedFindComponentFactory;
use Zrcms\HttpApi\CmsResource\HttpApiFindCmsResourceDynamic;
use Zrcms\HttpApi\CmsResource\HttpApiFindCmsResourceDynamicFactory;
use Zrcms\HttpApi\Component\HttpApiFindComponent;
use Zrcms\HttpApi\Params\HttpApiParamQuery;
use Zrcms\HttpApi\Validate\HttpApiIdAttributeZfInputFilterServiceHttpApi;
use Zrcms\HttpApi\Validate\HttpApiValidateIdAttributeDynamic;
use Zrcms\HttpApi\Validate\HttpApiValidateIdAttributeDynamicFactory;
use Zrcms\HttpApi\Validate\HttpApiValidateParamQueryDynamic;
use Zrcms\HttpApi\Validate\HttpApiValidateParamQueryDynamicFactory;
use Zrcms\InputValidation\Api\ValidateId;

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
                    HttpApiParamQuery::class => [],


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

                    HttpApiValidateParamQueryDynamic::class => [
                        'factory' => HttpApiValidateParamQueryDynamicFactory::class,
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
                            'isAllowed' => IsAllowedRcmUserSitesAdmin::class,
                            'isAllowedOptions' => [],
                            'notAllowedStatus' => 401,
                        ],
                        'validate-id-attribute' => [
                            'validate' => ValidateId::class,
                            'validateOptions' => [],
                            'notValidStatus' => 400,
                        ],
                        'api' => [
                            'apiService' => FindSiteCmsResource::class,
                            'toArray' => CmsResourceToArray::class,
                            'notFoundStatus' => 404,
                        ],
                    ],
                ],
            ],
        ];
    }
}
