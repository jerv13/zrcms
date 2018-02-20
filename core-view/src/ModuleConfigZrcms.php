<?php

namespace Zrcms\CoreView;

use Zrcms\Core\Api\Component\BuildComponentObject;
use Zrcms\CoreApplication\Api\Component\BuildComponentObjectByType;
use Zrcms\CoreView\Api\GetApplicationStateView;
use Zrcms\CoreView\Api\GetTagNamesByLayoutMustache;
use Zrcms\CoreView\Api\GetViewByRequestBasic;
use Zrcms\CoreView\Api\GetViewByRequestByPageVersion;
use Zrcms\CoreView\Api\GetViewByRequestHtmlPage;
use Zrcms\CoreView\Api\Render\GetViewLayoutTagsContainers;
use Zrcms\CoreView\Api\Render\GetViewLayoutTagsPage;
use Zrcms\CoreView\Api\Render\RenderViewLayout;
use Zrcms\CoreView\Fields\FieldsView;
use Zrcms\CoreView\Fields\FieldsViewLayoutTagsComponent;
use Zrcms\CoreView\Model\ServiceAliasView;
use Zrcms\CoreView\Model\ViewLayoutTagsComponent;
use Zrcms\CoreView\Model\ViewLayoutTagsComponentBasic;

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
             * ===== ZRCMS Application State =====
             */
            'zrcms-application-state' => [
                GetApplicationStateView::APPLICATION_STATE_KEY
                => GetApplicationStateView::class,
            ],

            /**
             * ===== Field Models =====
             * ['{model-name}' => '{model-class}']
             */
            'field-rat-fields-model' => [
                'view' => FieldsView::class,
                'view-layout-tags-component' => FieldsViewLayoutTagsComponent::class,
            ],

            /**
             * ===== Field Model Extends =====
             * ['{model-name}' => '{extends-model-name}']
             */
            'field-rat-fields-model-extends' => [
                'view' => 'content',
                'view-layout-tags-component' => 'component',
            ],

            /**
             * ===== Fields =====
             * ['{model-name}' => '{fields-config}']
             */
            'field-rat-fields' => [
                'view' => [
                    [
                        'name' => fieldsView::SITE_CMS_RESOURCE,
                        'type' => 'object',
                        'label' => 'SiteCmsResource',
                        'required' => true,
                        'default' => null,
                        'options' => [],
                    ],
                    [
                        'name' => fieldsView::PAGE_CMS_RESOURCE,
                        'type' => 'object',
                        'label' => 'PageCmsResource',
                        'required' => true,
                        'default' => null,
                        'options' => [],
                    ],
                    [
                        'name' => fieldsView::LAYOUT_CMS_RESOURCE,
                        'type' => 'object',
                        'label' => 'ThemeLayoutCmsResource',
                        'required' => true,
                        'default' => null,
                        'options' => [],
                    ],
                    [
                        'name' => fieldsView::RENDERER,
                        'type' => 'zrcms-service',
                        'label' => 'Renderer (layout renderer)',
                        'required' => false,
                        'default' => 'layout',
                        'options' => [],
                    ],
                ],
                'view-layout-tags-component' => [
                    [
                        'name' => FieldsViewLayoutTagsComponent::RENDER_TAGS_GETTER,
                        'type' => 'zrcms-service',
                        'label' => 'Render Tags Getter (GetRenderTags)',
                        'required' => false,
                        'default' => '',
                        'options' => [],
                    ],
                ],
            ],

            /**
             * ===== Service Alias =====
             */
            'zrcms-service-alias' => [
                // 'zrcms.view.content.view-layout-tags-getter'
                ServiceAliasView::ZRCMS_COMPONENT_VIEW_LAYOUT_TAGS_GETTER => [
                    GetViewLayoutTagsContainers::SERVICE_ALIAS
                    => GetViewLayoutTagsContainers::class,

                    GetViewLayoutTagsPage::SERVICE_ALIAS
                    => GetViewLayoutTagsPage::class,
                ],
                // 'zrcms.view.content.renderer'
                ServiceAliasView::ZRCMS_CONTENT_RENDERER => [
                    'layout' => RenderViewLayout::class,
                ],
                // 'zrcms.view.layout.tag-name-parser'
                ServiceAliasView::ZRCMS_LAYOUT_TAG_NAME_PARSER => [
                    'mustache' => GetTagNamesByLayoutMustache::class
                ],
            ],

            /**
             * ===== View mutator config =====
             */
            'zrcms-view-mutator' => [
                // 'key (optional)' => '{service-name}'
            ],

            /**
             * ===== View By Request Composite =====
             * '{strategy-name}' => ['api' => '{GetViewByRequestServiceName}', 'priority' => {int}]
             */
            'zrcms-view-by-request-composite' => [
                'basic' => [
                    'api' => GetViewByRequestBasic::class,
                    'priority' => -1,
                ],

                'html-page' => [
                    'api' => GetViewByRequestHtmlPage::class,
                    'priority' => 100,
                ],

                'page-version' => [
                    'api' => GetViewByRequestByPageVersion::class,
                    'priority' => 200,
                ],
            ],

            /**
             * ===== ZRCMS Types =====
             */
            'zrcms-types' => [
                'view-layout-tag' => [
                    BuildComponentObject::class => BuildComponentObjectByType::class,
                    'component-model-interface' => ViewLayoutTagsComponent::class,
                    'component-model-class' => ViewLayoutTagsComponentBasic::class,
                ]
            ],
        ];
    }
}
