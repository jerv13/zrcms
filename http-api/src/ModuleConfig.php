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
use Zrcms\HttpApi\CmsResourceHistory\HttpApiFindCmsResourceHistoryByDynamic;
use Zrcms\HttpApi\CmsResourceHistory\HttpApiFindCmsResourceHistoryDynamic;
use Zrcms\HttpApi\CmsResourceHistory\HttpApiFindCmsResourceHistoryDynamicFactory;
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
use Zrcms\HttpApi\ZrcmsConfig\HttpApiIsAllowedZrcmsConfig;
use Zrcms\HttpApi\ZrcmsConfig\HttpApiIsAllowedZrcmsConfigFactory;
use Zrcms\HttpApi\ZrcmsConfig\HttpApiZrcmsConfig;
use Zrcms\HttpApi\ZrcmsConfig\HttpApiZrcmsConfigFactory;
use Zrcms\HttpApi\ZrcmsConfig\HttpApiZrcmsRoutes;
use Zrcms\HttpApi\ZrcmsConfig\HttpApiZrcmsRoutesFactory;

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
                     * CmsResourceHistory ===========================================
                     */
                    HttpApiFindCmsResourceHistoryByDynamic::class => [
                        'factory' => HttpApiUpsertCmsResourceDynamicFactory::class,
                    ],

                    HttpApiFindCmsResourceHistoryDynamic::class => [
                        'factory' => HttpApiFindCmsResourceHistoryDynamicFactory::class,
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

                    HttpApiIsAllowedZrcmsConfig::class => [
                        'factory' => HttpApiIsAllowedZrcmsConfigFactory::class,
                    ],

                    HttpApiZrcmsConfig::class => [
                        'factory' => HttpApiZrcmsConfigFactory::class,
                    ],

                    HttpApiZrcmsRoutes::class => [
                        'factory' => HttpApiZrcmsRoutesFactory::class,
                    ],

                    /**
                     * General ===========================================
                     */
                    GetDynamicApiConfig::class => [
                        'factory' => GetDynamicApiConfigAppConfigFactory::class,
                    ],
                ],
            ],
        ];
    }
}
