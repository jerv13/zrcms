<?php

namespace Zrcms\CoreTheme;

use Zrcms\Core\Api\Component\BuildComponentObject;
use Zrcms\Core\Model\ServiceAliasComponent;
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
use Zrcms\CoreTheme\Model\ServiceAliasTheme;
use Zrcms\CoreTheme\Model\ThemeComponent;
use Zrcms\CoreTheme\Model\ThemeComponentBasic;
use Zrcms\CoreView\Model\ServiceAliasView;
use Zrcms\ServiceAlias\Api\Validator\ValidateIsZrcmsServiceAlias;

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
             * ===== Field Models =====
             * ['{model-name}' => '{model-class}']
             */
            'field-rat-fields-model' => [
                FieldsLayoutComponent::FIELD_MODEL_NAME => FieldsLayoutComponent::class,
                FieldsLayoutComponentConfig::FIELD_MODEL_NAME => FieldsLayoutComponentConfig::class,
                FieldsLayoutVersion::FIELD_MODEL_NAME => FieldsLayoutVersion::class,
                FieldsThemeComponent::FIELD_MODEL_NAME => FieldsThemeComponent::class,
                FieldsThemeComponentConfig::FIELD_MODEL_NAME => FieldsThemeComponentConfig::class,
            ],

            /**
             * ===== Field Model Extends =====
             * ['{model-name}' => '{extends-model-name}']
             */
            'field-rat-fields-model-extends' => [
                FieldsLayoutComponent::FIELD_MODEL_NAME => 'component',
                FieldsLayoutComponentConfig::FIELD_MODEL_NAME => 'component-config',
                FieldsLayoutVersion::FIELD_MODEL_NAME => 'content-version',
                FieldsThemeComponent::FIELD_MODEL_NAME => 'component',
                FieldsThemeComponentConfig::FIELD_MODEL_NAME => 'component-config',
            ],

            /**
             * ===== Fields =====
             * ['{model-name}' => '{fields-config}']
             */
            'field-rat-fields' => [
                FieldsLayoutComponent::FIELD_MODEL_NAME => [
                    [
                        'name' => FieldsLayoutComponent::THEME_NAME,
                        'type' => 'text',
                        'label' => 'Theme Name',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsLayoutComponent::HTML,
                        'type' => 'text',
                        'label' => 'Template HTML',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsLayoutComponent::RENDERER,
                        'type' => 'zrcms-service',
                        'label' => 'Renderer',
                        'required' => false,
                        'default' => 'mustache',
                        'options' => [
                            ValidateIsZrcmsServiceAlias::OPTION_SERVICE_ALIAS_NAMESPACE
                            => ServiceAliasLayout::ZRCMS_CONTENT_RENDERER
                        ],
                    ],
                    [
                        'name' => FieldsLayoutComponent::RENDER_TAGS_GETTER,
                        'type' => 'zrcms-service',
                        'label' => 'Render Tags Getter (GetRenderTags)',
                        'required' => false,
                        'default' => '',
                        'options' => [
                            ValidateIsZrcmsServiceAlias::OPTION_SERVICE_ALIAS_NAMESPACE
                            => ServiceAliasLayout::ZRCMS_CONTENT_RENDER_TAGS_GETTER
                        ],
                    ],
                    [
                        'name' => FieldsLayoutComponent::RENDER_TAG_NAME_PARSER,
                        'type' => 'zrcms-service',
                        'label' => 'Tag Name Parser',
                        'required' => false,
                        'default' => 'mustache',
                        'options' => [
                            ValidateIsZrcmsServiceAlias::OPTION_SERVICE_ALIAS_NAMESPACE
                            => ServiceAliasView::ZRCMS_LAYOUT_TAG_NAME_PARSER
                        ],
                    ],
                ],
                FieldsLayoutComponentConfig::FIELD_MODEL_NAME => [
                    [
                        'name' => FieldsLayoutComponentConfig::TYPE,
                        'type' => 'text',
                        'label' => 'Component Type',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsLayoutComponentConfig::NAME,
                        'type' => 'text',
                        'label' => 'Name',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsLayoutComponentConfig::CREATED_BY_USER_ID,
                        'type' => 'string',
                        'label' => 'Created By User ID',
                        'required' => false,
                        'default' => Trackable::UNKNOWN_USER_ID,
                        'options' => [],
                    ],
                    [
                        'name' => FieldsLayoutComponentConfig::CREATED_REASON,
                        'type' => 'string',
                        'label' => 'Created Reason',
                        'required' => false,
                        'default' => Trackable::UNKNOWN_REASON,
                        'options' => [],
                    ],
                    [
                        'name' => FieldsLayoutComponentConfig::COMPONENT_CONFIG_READER,
                        'type' => 'zrcms-service',
                        'label' => 'Component Config Reader',
                        'required' => false,
                        'default' => 'json',
                        'options' => [
                            ValidateIsZrcmsServiceAlias::OPTION_SERVICE_ALIAS_NAMESPACE
                            => ServiceAliasComponent::ZRCMS_COMPONENT_CONFIG_READER
                        ],
                    ],
                    [
                        'name' => FieldsLayoutComponentConfig::COMPONENT_CLASS,
                        'type' => 'class',
                        'label' => 'Component Class',
                        'required' => false,
                        'default' => LayoutComponentBasic::class,
                        'options' => [],
                    ],
                    [
                        'name' => FieldsLayoutComponentConfig::RENDERER,
                        'type' => 'zrcms-service',
                        'label' => 'Renderer',
                        'required' => false,
                        'default' => 'mustache',
                        'options' => [
                            ValidateIsZrcmsServiceAlias::OPTION_SERVICE_ALIAS_NAMESPACE
                            => ServiceAliasComponent::ZRCMS_COMPONENT_CONFIG_READER
                        ],
                    ],
                    [
                        'name' => FieldsLayoutComponentConfig::RENDER_TAGS_GETTER,
                        'type' => 'zrcms-service',
                        'label' => 'Render Tags Getter (GetRenderTags)',
                        'required' => false,
                        'default' => '',
                        'options' => [
                            ValidateIsZrcmsServiceAlias::OPTION_SERVICE_ALIAS_NAMESPACE
                            => ServiceAliasLayout::ZRCMS_CONTENT_RENDER_TAGS_GETTER
                        ],
                    ],
                    [
                        'name' => FieldsLayoutComponentConfig::RENDER_TAG_NAME_PARSER,
                        'type' => 'zrcms-service',
                        'label' => 'Tag Name Parser',
                        'required' => false,
                        'default' => 'mustache',
                        'options' => [
                            ValidateIsZrcmsServiceAlias::OPTION_SERVICE_ALIAS_NAMESPACE
                            => ServiceAliasView::ZRCMS_LAYOUT_TAG_NAME_PARSER
                        ],
                    ],
                    [
                        'name' => FieldsLayoutComponentConfig::THEME_NAME,
                        'type' => 'string',
                        'label' => 'Theme Name',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsLayoutComponentConfig::TEMPLATE_FILE,
                        'type' => 'string',
                        'label' => 'Template File',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                ],
                FieldsLayoutVersion::FIELD_MODEL_NAME => [
                    [
                        'name' => FieldsLayoutVersion::THEME_NAME,
                        'type' => 'text',
                        'label' => 'Theme Name',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsLayoutVersion::NAME,
                        'type' => 'text',
                        'label' => 'Layout Name',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsLayoutVersion::RENDERER,
                        'type' => 'zrcms-service',
                        'label' => 'Renderer',
                        'required' => false,
                        'default' => 'mustache',
                        'options' => [
                            ValidateIsZrcmsServiceAlias::OPTION_SERVICE_ALIAS_NAMESPACE
                            => ServiceAliasLayout::ZRCMS_CONTENT_RENDERER
                        ],
                    ],
                    [
                        'name' => FieldsLayoutVersion::RENDER_TAGS_GETTER,
                        'type' => 'zrcms-service',
                        'label' => 'Render Tags Getter (GetRenderTags)',
                        'required' => false,
                        'default' => '',
                        'options' => [
                            ValidateIsZrcmsServiceAlias::OPTION_SERVICE_ALIAS_NAMESPACE
                            => ServiceAliasLayout::ZRCMS_CONTENT_RENDER_TAGS_GETTER
                        ],
                    ],
                    [
                        'name' => FieldsLayoutVersion::RENDER_TAG_NAME_PARSER,
                        'type' => 'zrcms-service',
                        'label' => 'Tag Name Parser',
                        'required' => false,
                        'default' => 'mustache',
                        'options' => [
                            ValidateIsZrcmsServiceAlias::OPTION_SERVICE_ALIAS_NAMESPACE
                            => ServiceAliasView::ZRCMS_LAYOUT_TAG_NAME_PARSER
                        ],
                    ],
                    [
                        'name' => FieldsLayoutVersion::HTML,
                        'type' => 'text',
                        'label' => 'Template HTML',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                ],
                FieldsThemeComponent::FIELD_MODEL_NAME => [
                    [
                        'name' => FieldsThemeComponent::PRIMARY_LAYOUT_NAME,
                        'type' => 'text',
                        'label' => 'Primary Layout Name',
                        'required' => true,
                        'default' => FieldsThemeComponent::DEFAULT_PRIMARY_LAYOUT_NAME,
                        'options' => [],
                    ],
                    [
                        'name' => FieldsThemeComponent::LAYOUT_VARIATIONS,
                        'type' => 'array',
                        'label' => 'Layout Variation Locations',
                        'required' => true,
                        'default' => [],
                        'options' => [],
                    ],
                ],
                FieldsThemeComponentConfig::FIELD_MODEL_NAME => [
                    [
                        'name' => FieldsThemeComponentConfig::TYPE,
                        'type' => 'text',
                        'label' => 'Component Type',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsThemeComponentConfig::NAME,
                        'type' => 'text',
                        'label' => 'Name',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsThemeComponentConfig::CREATED_BY_USER_ID,
                        'type' => 'string',
                        'label' => 'Created By User ID',
                        'required' => false,
                        'default' => Trackable::UNKNOWN_USER_ID,
                        'options' => [],
                    ],
                    [
                        'name' => FieldsThemeComponentConfig::CREATED_REASON,
                        'type' => 'string',
                        'label' => 'Created Reason',
                        'required' => false,
                        'default' => Trackable::UNKNOWN_REASON,
                        'options' => [],
                    ],
                    [
                        'name' => FieldsThemeComponentConfig::COMPONENT_CONFIG_READER,
                        'type' => 'zrcms-service',
                        'label' => 'Component Config Reader',
                        'required' => false,
                        'default' => 'json',
                        'options' => [
                            ValidateIsZrcmsServiceAlias::OPTION_SERVICE_ALIAS_NAMESPACE
                            => ServiceAliasComponent::ZRCMS_COMPONENT_CONFIG_READER
                        ],
                    ],
                    [
                        'name' => FieldsThemeComponentConfig::COMPONENT_CLASS,
                        'type' => 'class',
                        'label' => 'Component Class',
                        'required' => false,
                        'default' => ThemeComponentBasic::class,
                        'options' => [],
                    ],
                    [
                        'name' => FieldsThemeComponentConfig::PRIMARY_LAYOUT,
                        'type' => 'text',
                        'label' => 'Primary Layout Name',
                        'required' => true,
                        'default' => FieldsThemeComponentConfig::DEFAULT_PRIMARY_LAYOUT_NAME,
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
            'zrcms-component-types' => [
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
