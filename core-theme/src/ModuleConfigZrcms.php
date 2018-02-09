<?php

namespace Zrcms\CoreTheme;

use Zrcms\Core\Api\Component\BuildComponentObject;
use Zrcms\Core\Model\Trackable;
use Zrcms\CoreTheme\Api\Component\BuildComponentObjectThemeLayout;
use Zrcms\CoreTheme\Api\Component\BuildComponentObjectThemeLayouts;
use Zrcms\CoreTheme\Api\Render\RenderLayoutMustache;
use Zrcms\CoreTheme\Fields\FieldsLayoutComponent;
use Zrcms\CoreTheme\Fields\FieldsLayoutComponentConfig;
use Zrcms\CoreTheme\Fields\FieldsLayoutVersion;
use Zrcms\CoreTheme\Fields\FieldsThemeComponent;
use Zrcms\CoreTheme\Fields\FieldsThemeComponentConfig;
use Zrcms\CoreTheme\Model\LayoutComponent;
use Zrcms\CoreTheme\Model\LayoutComponentBasic;
use Zrcms\CoreTheme\Model\ServiceAliasLayout;
use Zrcms\CoreTheme\Model\ThemeComponent;
use Zrcms\CoreTheme\Model\ThemeComponentBasic;

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
             * ===== ZRCMS Field Models =====
             * ['{model-name}' => '{model-class}']
             */
            'field-rat-fields-model' => [
                'layout-component' => FieldsLayoutComponent::class,
                'layout-component-config' => FieldsLayoutComponentConfig::class,
                'layout-version' => FieldsLayoutVersion::class,
                'theme-component' => FieldsThemeComponent::class,
                'theme-component-config' => FieldsThemeComponentConfig::class,
            ],

            /**
             * ===== ZRCMS Field Model Extends =====
             * ['{model-name}' => '{extends-model-name}']
             */
            'field-rat-fields-model-extends' => [
                'layout-component' => 'component',
                'layout-component-config' => 'component-config',
                'layout-version' => 'content-version',
                'theme-component' => 'component',
                'theme-component-config' => 'component-config',
            ],

            /**
             * ===== ZRCMS Fields =====
             * ['{model-name}' => '{fields-config}']
             */
            'field-rat-fields' => [
                'layout-component' => [
                    [
                        'name' => fieldsLayoutComponent::THEME_NAME,
                        'type' => 'text',
                        'label' => 'Theme Name',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => fieldsLayoutComponent::HTML,
                        'type' => 'text',
                        'label' => 'Template HTML',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => fieldsLayoutComponent::RENDERER,
                        'type' => 'zrcms-service',
                        'label' => 'Renderer',
                        'required' => false,
                        'default' => 'mustache',
                        'options' => [],
                    ],
                    [
                        'name' => fieldsLayoutComponent::RENDER_TAGS_GETTER,
                        'type' => 'zrcms-service',
                        'label' => 'Render Tags Getter (GetRenderTags)',
                        'required' => false,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => fieldsLayoutComponent::RENDER_TAG_NAME_PARSER,
                        'type' => 'zrcms-service',
                        'label' => 'Tag Name Parser',
                        'required' => false,
                        'default' => 'mustache',
                        'options' => [],
                    ],
                ],
                'layout-component-config' => [
                    [
                        'name' => fieldsLayoutComponentConfig::TYPE,
                        'type' => 'text',
                        'label' => 'Component Type',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => fieldsLayoutComponentConfig::NAME,
                        'type' => 'text',
                        'label' => 'Name',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => fieldsLayoutComponentConfig::CREATED_BY_USER_ID,
                        'type' => 'zrcms-service',
                        'label' => 'Created By User ID',
                        'required' => false,
                        'default' => Trackable::UNKNOWN_USER_ID,
                        'options' => [],
                    ],
                    [
                        'name' => fieldsLayoutComponentConfig::CREATED_REASON,
                        'type' => 'class',
                        'label' => 'Component Class',
                        'required' => false,
                        'default' => Trackable::UNKNOWN_REASON,
                        'options' => [],
                    ],
                    [
                        'name' => fieldsLayoutComponentConfig::COMPONENT_CONFIG_READER,
                        'type' => 'zrcms-service',
                        'label' => 'Component Config Reader',
                        'required' => false,
                        'default' => 'json',
                        'options' => [],
                    ],
                    [
                        'name' => fieldsLayoutComponentConfig::COMPONENT_CLASS,
                        'type' => 'class',
                        'label' => 'Component Class',
                        'required' => false,
                        'default' => LayoutComponentBasic::class,
                        'options' => [],
                    ],
                    [
                        'name' => fieldsLayoutComponentConfig::RENDERER,
                        'type' => 'zrcms-service',
                        'label' => 'Renderer',
                        'required' => false,
                        'default' => 'mustache',
                        'options' => [],
                    ],
                    [
                        'name' => fieldsLayoutComponentConfig::RENDER_TAGS_GETTER,
                        'type' => 'zrcms-service',
                        'label' => 'Render Tags Getter (GetRenderTags)',
                        'required' => false,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => fieldsLayoutComponentConfig::RENDER_TAG_NAME_PARSER,
                        'type' => 'zrcms-service',
                        'label' => 'Tag Name Parser',
                        'required' => false,
                        'default' => 'mustache',
                        'options' => [],
                    ],
                    [
                        'name' => fieldsLayoutComponentConfig::THEME_NAME,
                        'type' => 'string',
                        'label' => 'Theme Name',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => fieldsLayoutComponentConfig::TEMPLATE_FILE,
                        'type' => 'string',
                        'label' => 'Template File',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                ],
                'layout-version' => [
                    [
                        'name' => fieldsLayoutVersion::THEME_NAME,
                        'type' => 'text',
                        'label' => 'Theme Name',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => fieldsLayoutVersion::NAME,
                        'type' => 'text',
                        'label' => 'Layout Name',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => fieldsLayoutVersion::RENDERER,
                        'type' => 'zrcms-service',
                        'label' => 'Renderer',
                        'required' => false,
                        'default' => 'mustache',
                        'options' => [],
                    ],
                    [
                        'name' => fieldsLayoutVersion::RENDER_TAGS_GETTER,
                        'type' => 'zrcms-service',
                        'label' => 'Render Tags Getter (GetRenderTags)',
                        'required' => false,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => fieldsLayoutVersion::RENDER_TAG_NAME_PARSER,
                        'type' => 'zrcms-service',
                        'label' => 'Tag Name Parser',
                        'required' => false,
                        'default' => 'mustache',
                        'options' => [],
                    ],
                    [
                        'name' => fieldsLayoutVersion::HTML,
                        'type' => 'text',
                        'label' => 'Template HTML',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                ],
                'theme-component' => [
                    [
                        'name' => fieldsThemeComponent::PRIMARY_LAYOUT_NAME,
                        'type' => 'text',
                        'label' => 'Primary Layout Name',
                        'required' => true,
                        'default' => fieldsThemeComponent::DEFAULT_PRIMARY_LAYOUT_NAME,
                        'options' => [],
                    ],
                    [
                        'name' => fieldsThemeComponent::LAYOUT_VARIATIONS,
                        'type' => 'array',
                        'label' => 'Layout Variation Locations',
                        'required' => true,
                        'default' => [],
                        'options' => [],
                    ],
                ],
                'theme-component-config' => [
                    [
                        'name' => fieldsThemeComponentConfig::TYPE,
                        'type' => 'text',
                        'label' => 'Component Type',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => fieldsThemeComponentConfig::NAME,
                        'type' => 'text',
                        'label' => 'Name',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => fieldsThemeComponentConfig::CREATED_BY_USER_ID,
                        'type' => 'zrcms-service',
                        'label' => 'Created By User ID',
                        'required' => false,
                        'default' => Trackable::UNKNOWN_USER_ID,
                        'options' => [],
                    ],
                    [
                        'name' => fieldsThemeComponentConfig::CREATED_REASON,
                        'type' => 'class',
                        'label' => 'Component Class',
                        'required' => false,
                        'default' => Trackable::UNKNOWN_REASON,
                        'options' => [],
                    ],
                    [
                        'name' => fieldsThemeComponentConfig::COMPONENT_CONFIG_READER,
                        'type' => 'zrcms-service',
                        'label' => 'Component Config Reader',
                        'required' => false,
                        'default' => 'json',
                        'options' => [],
                    ],
                    [
                        'name' => fieldsThemeComponentConfig::COMPONENT_CLASS,
                        'type' => 'class',
                        'label' => 'Component Class',
                        'required' => false,
                        'default' => ThemeComponentBasic::class,
                        'options' => [],
                    ],
                    [
                        'name' => fieldsThemeComponentConfig::PRIMARY_LAYOUT,
                        'type' => 'text',
                        'label' => 'Primary Layout Name',
                        'required' => true,
                        'default' => fieldsThemeComponentConfig::DEFAULT_PRIMARY_LAYOUT_NAME,
                        'options' => [],
                    ],
                ],
            ],

            /**
             * ===== Service Alias =====
             */
            'zrcms-service-alias' => [
                // @todo IS THIS USED? 'zrcms.layout.content.render-tags-getter'
                ServiceAliasLayout::ZRCMS_CONTENT_RENDERER => [
                    'mustache'
                    => RenderLayoutMustache::class,
                ],
            ],

            /**
             * ===== ZRCMS Types =====
             */
            'zrcms-types' => [
                'theme' => [
                    BuildComponentObject::class => BuildComponentObjectThemeLayouts::class,
                    'component-model-interface' => ThemeComponent::class,
                    'component-model-class' => ThemeComponentBasic::class,
                ],
                'theme-layout' => [
                    BuildComponentObject::class => BuildComponentObjectThemeLayout::class,
                    'component-model-interface' => LayoutComponent::class,
                    'component-model-class' => LayoutComponentBasic::class,
                ]
            ],
        ];
    }
}
