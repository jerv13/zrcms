<?php

namespace Zrcms\HttpExpressive1;

use Zrcms\Acl\Api\IsAllowed;
use Zrcms\Content\Api\ContentVersionToArray;
use Zrcms\ContentCore\Basic\Api\Repository\FindBasicComponent;
use Zrcms\ContentCore\Basic\Api\Repository\ReadBasicComponentConfigApplicationConfig;
use Zrcms\ContentCore\Site\Model\PropertiesSiteVersion;
use Zrcms\ContentCore\Site\Model\SiteVersionBasic;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags;
use Zrcms\ContentCore\View\Api\Render\RenderView;
use Zrcms\ContentCore\View\Api\Repository\FindViewByRequest;
use Zrcms\ContentCore\View\Model\ServiceAliasView;
use Zrcms\ContentCoreConfigDataSource\Content\Model\ComponentRegistryFields;
use Zrcms\HttpExpressive1\Api\View\Render\GetViewLayoutMetaPageData;
use Zrcms\HttpExpressive1\ApiHttp\Site\Repository\FindSiteVersion;
use Zrcms\HttpExpressive1\ApiHttp\Site\Repository\InsertSiteVersion;
use Zrcms\HttpExpressive1\Model\HttpExpressiveComponent;
use Zrcms\HttpExpressive1\Model\PropertiesHttpExpressiveComponent;
use Zrcms\HttpExpressive1\Render\ViewController;
use Zrcms\HttpExpressive1\Render\ViewControllerFallbackPage;
use Zrcms\HttpExpressive1\Render\ViewControllerTest;
use Zrcms\HttpExpressive1\Render\ViewControllerTestFactory;
use Zrcms\HttpResponseHandler\Api\HandleResponse;
use Zrcms\User\Api\GetUserIdByRequest;
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
                     * ApiHttp ===========================================
                     */
                    GetViewLayoutMetaPageData::class => [
                        'arguments' => [
                            RenderTag::class,
                            IsAllowed::class,
                            ['literal' => 'site'],
                            ['literal' => 'admin'],
                        ],
                    ],
                    /**
                     * ApiHttp ===========================================
                     */
                    FindSiteVersion::class => [
                        'arguments' => [
                            \Zrcms\ContentCore\Site\Api\Repository\FindSiteVersion::class,
                            ContentVersionToArray::class,
                            ['literal' => 'site-repository-find-content-version'],
                        ],
                    ],
                    InsertSiteVersion::class => [
                        'arguments' => [
                            \Zrcms\Content\Api\Repository\InsertContentVersion::class,
                            ContentVersionToArray::class,
                            GetUserIdByRequest::class,
                            ['literal' => SiteVersionBasic::class],
                            ['literal' => 'site-repository-insert-content-version'],
                        ],
                    ],
                    /**
                     * Render ===========================================
                     */
                    ViewController::class => [
                        'arguments' => [
                            FindViewByRequest::class,
                            GetViewLayoutTags::class,
                            RenderView::class,
                            HandleResponse::class,
                        ],
                    ],
                    ViewControllerFallbackPage::class => [
                        'arguments' => [
                            FindBasicComponent::class,
                            HandleResponse::class,
                            ViewController::class,
                        ],
                    ],
                    ViewControllerTest::class => [
                        'factory' => ViewControllerTestFactory::class,
                    ],
                ],
            ],
            'routes' => [
                'zrcms.test-render' => [
                    'name' => 'zrcms.test-render',
                    'path' => '/zrcms/test-render',
                    'middleware' => ViewControllerTest::class,
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
                'zrcms.site.repository.find-content-version' => [
                    'name' => 'zrcms.site.repository.find-content-version',
                    'path' => '/zrcms/site/repository/find-content-version/{id}',
                    'middleware' => [
                        FindSiteVersion::class => FindSiteVersion::class,
                    ],
                    'options' => [],
                    'allowed_methods' => ['GET'],
                ],
            ],

            'zrcms-components' => [
                'basic' => [
                    /* 'zrcms-http-expressive-1' */
                    HttpExpressiveComponent::NAME => [
                        ComponentRegistryFields::NAME
                        => HttpExpressiveComponent::NAME,

                        ComponentRegistryFields::CONFIG_LOCATION
                        => HttpExpressiveComponent::NAME,

                        ComponentRegistryFields::COMPONENT_CONFIG_READER
                        => ReadBasicComponentConfigApplicationConfig::SERVICE_ALIAS,

                        /* Map of HTTP status to the name of a SiteVersion property with the corresponding path */
                        PropertiesHttpExpressiveComponent::STATUS_TO_SITE_PATH_PROPERTY => [
                            '404' => PropertiesSiteVersion::NOT_FOUND_PAGE,
                            '401' => PropertiesSiteVersion::NOT_AUTHORIZED_PAGE,
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
