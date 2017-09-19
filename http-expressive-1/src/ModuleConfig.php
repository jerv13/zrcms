<?php

namespace Zrcms\HttpExpressive1;

use Zrcms\Acl\Api\IsAllowedAny;
use Zrcms\ContentCore\Basic\Api\Component\ReadBasicComponentConfigApplicationConfig;
use Zrcms\ContentCore\Basic\Api\Repository\FindBasicComponent;
use Zrcms\ContentCore\Site\Api\GetSiteCmsResourceByRequest;
use Zrcms\ContentCore\View\Model\ServiceAliasView;
use Zrcms\ContentCoreConfigDataSource\Content\Fields\FieldsComponentRegistry;
use Zrcms\HttpExpressive1\Api\GetStatusPage;
use Zrcms\HttpExpressive1\Api\GetStatusPageBasic;
use Zrcms\HttpExpressive1\Api\View\Render\GetViewLayoutMetaPageData;
use Zrcms\HttpExpressive1\Fields\FieldsHttpExpressiveComponent;
use Zrcms\HttpExpressive1\Model\HttpExpressiveComponent;
use Zrcms\ViewHtmlTags\Api\Render\RenderTag;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ModuleConfig
{
    /**
     * __invoke
     *
     * @return array
     */
    public function __invoke()
    {
        return [
            'dependencies' => [
                'config_factories' => [
                    /**
                     * Api ===========================================
                     */
                    GetViewLayoutMetaPageData::class => [
                        'arguments' => [
                            RenderTag::class,
                            // @todo Real ACL??
                            IsAllowedAny::class,
                            [
                                'literal' => [
                                    //IsAllowedRcmUser::OPTION_RESOURCE_ID => 'sites',
                                    //IsAllowedRcmUser::OPTION_PRIVILEGE => 'admin',
                                ]
                            ],
                        ],
                    ],

                    GetStatusPage::class => [
                        'class' => GetStatusPageBasic::class,
                        'arguments' => [
                            GetSiteCmsResourceByRequest::class,
                            FindBasicComponent::class,
                        ],
                    ],
                ],
            ],

            'zrcms-components' => [
                'basic' => [
                    /* 'zrcms-http-expressive-1' */
                    HttpExpressiveComponent::NAME => [
                        FieldsComponentRegistry::NAME
                        => HttpExpressiveComponent::NAME,

                        FieldsComponentRegistry::CONFIG_LOCATION
                        => HttpExpressiveComponent::NAME,

                        FieldsComponentRegistry::COMPONENT_CONFIG_READER
                        => ReadBasicComponentConfigApplicationConfig::SERVICE_ALIAS,

                        FieldsComponentRegistry::COMPONENT_CLASS
                        => HttpExpressiveComponent::class,

                        /* Map of HTTP status to the path and a type */
                        FieldsHttpExpressiveComponent::STATUS_TO_SITE_PATH_PROPERTY => [
                            '401' => [
                                'path' => '/not-authorized',
                                'type' => 'render',
                            ],
                            '404' => [
                                'path' => '/not-found',
                                'type' => 'render',
                            ],
                        ],
                    ],
                ],
                'view-layout-tags' => [
                    GetViewLayoutMetaPageData::RENDER_TAG_META_PAGE_DATA
                    => __DIR__ . '/../config/meta-page-data',
                ],
            ],

            'zrcms-service-alias' => [
                ServiceAliasView::NAMESPACE_COMPONENT_VIEW_LAYOUT_TAGS_GETTER => [
                    GetViewLayoutMetaPageData::RENDER_TAG_META_PAGE_DATA
                    => GetViewLayoutMetaPageData::class
                ],
            ],
        ];
    }
}
