<?php

namespace Zrcms\HttpStatusPages;

use Zrcms\Content\Api\Component\FindComponent;
use Zrcms\Content\Fields\FieldsComponentRegistry;
use Zrcms\ContentCore\Basic\Api\Component\ReadBasicComponentConfigApplicationConfig;
use Zrcms\ContentCore\Site\Api\GetSiteCmsResourceByRequest;
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
                        ],
                    ],
                ],
            ],

            'zrcms-components' => [
                'basic' => [
                    /* 'zrcms-http-expressive-1' */
                    HttpStatusPagesComponent::NAME => [
                        FieldsComponentRegistry::NAME
                        => HttpStatusPagesComponent::NAME,

                        FieldsComponentRegistry::CONFIG_LOCATION
                        => HttpStatusPagesComponent::NAME,

                        FieldsComponentRegistry::COMPONENT_CONFIG_READER
                        => ReadBasicComponentConfigApplicationConfig::SERVICE_ALIAS,

                        FieldsComponentRegistry::COMPONENT_CLASS
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
                ],
            ],
        ];
    }
}
