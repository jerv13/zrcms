<?php

namespace Zrcms\HttpStatusPages;

use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\Core\Fields\FieldsComponentConfig;
use Zrcms\CoreSite\Api\GetSiteCmsResourceByRequest;
use Zrcms\Debug\IsDebug;
use Zrcms\HttpStatusPages\Api\GetStatusPage;
use Zrcms\HttpStatusPages\Api\GetStatusPageBasic;
use Zrcms\HttpStatusPages\Fields\FieldsHttpStatusPagesComponent;
use Zrcms\HttpStatusPages\Middleware\ResponseMutatorStatusPage;
use Zrcms\HttpStatusPages\Model\HttpStatusPagesComponent;
use Zrcms\HttpViewRender\Response\RenderPage;

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
                    GetStatusPage::class => [
                        'class' => GetStatusPageBasic::class,
                        'arguments' => [
                            GetSiteCmsResourceByRequest::class,
                            FindComponent::class,
                        ],
                    ],

                    ResponseMutatorStatusPage::class => [
                        'arguments' => [
                            GetStatusPage::class,
                            RenderPage::class,
                            ['literal' => ['text/html', 'application/xhtml+xml', 'text/xml', 'application/xml', '']],
                            ['literal' => [200, 201, 204, 301, 302]],
                            ['literal' => IsDebug::invoke()],
                        ],
                    ],
                ],
            ],

            'zrcms-components' => [
                'basic.zrcms-http-status-pages' => 'app-config:zrcms-http-status-pages',
            ],

            'zrcms-http-status-pages' => [
                FieldsComponentConfig::TYPE => 'basic',
                FieldsComponentConfig::NAME => HttpStatusPagesComponent::NAME,
                FieldsComponentConfig::MODULE_DIRECTORY => __DIR__ . '/..',
                FieldsComponentConfig::COMPONENT_CLASS
                => HttpStatusPagesComponent::class,

                /**
                 * Map of HTTP status to the path and a type
                 * 'status-to-site-page-path-property-map'
                 */
                FieldsHttpStatusPagesComponent::STATUS_TO_SITE_PATH_PROPERTY => [
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
        ];
    }
}
