<?php

namespace Zrcms\CoreBlock;

use Zrcms\Core\Model\ServiceAliasComponent;
use Zrcms\Core\Model\Trackable;
use Zrcms\CoreBlock\Api\Component\ReadComponentConfigBlockBc;
use Zrcms\CoreBlock\Api\Component\ReadComponentConfigJsonFile;
use Zrcms\CoreBlock\Api\Component\ReadComponentConfigJsonFileBc;
use Zrcms\CoreBlock\Api\Component\ReadComponentRegistryRcmPluginBc;
use Zrcms\CoreBlock\Api\GetBlockDataNoop;
use Zrcms\CoreBlock\Api\Render\RenderBlockBc;
use Zrcms\CoreBlock\Api\Render\RenderBlockMustache;
use Zrcms\CoreBlock\Fields\FieldsBlockComponent;
use Zrcms\CoreBlock\Fields\FieldsBlockComponentConfig;
use Zrcms\CoreBlock\Fields\FieldsBlockVersion;
use Zrcms\CoreBlock\Model\BlockComponent;
use Zrcms\CoreBlock\Model\BlockComponentBasic;
use Zrcms\CoreBlock\Model\ServiceAliasBlock;
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
             * ===== ZRCMS Component Registry Readers =====
             */
            'zrcms-component-registry-readers' => [
                ReadComponentRegistryRcmPluginBc::class => ReadComponentRegistryRcmPluginBc::class,
            ],
            /**
             * ===== Field Models =====
             * ['{model-name}' => '{model-class}']
             */
            'field-rat-fields-model' => [
                FieldsBlockComponent::FIELD_MODEL_NAME => FieldsBlockComponent::class,
                FieldsBlockComponentConfig::FIELD_MODEL_NAME => FieldsBlockComponentConfig::class,
                FieldsBlockVersion::FIELD_MODEL_NAME => FieldsBlockVersion::class,
            ],

            /**
             * ===== Field Model Extends =====
             * ['{model-name}' => '{extends-model-name}']
             */
            'field-rat-fields-model-extends' => [
                FieldsBlockComponent::FIELD_MODEL_NAME => 'component',
                FieldsBlockComponentConfig::FIELD_MODEL_NAME => 'component-config',
                FieldsBlockVersion::FIELD_MODEL_NAME => 'content-version'
            ],

            /**
             * ===== Fields =====
             * ['{model-name}' => '{fields-config}']
             */
            'field-rat-fields' => [
                FieldsBlockComponent::FIELD_MODEL_NAME => [
                    [
                        'name' => FieldsBlockComponent::COMPONENT_CONFIG_READER,
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
                        'name' => FieldsBlockComponent::COMPONENT_CLASS,
                        'type' => 'class',
                        'label' => 'Component Class',
                        'required' => false,
                        'default' => BlockComponentBasic::class,
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockComponent::JAVASCRIPT,
                        'type' => 'array',
                        'label' => 'Javascript includes',
                        'required' => false,
                        'default' => [],
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockComponent::CSS,
                        'type' => 'array',
                        'label' => 'CSS Includes',
                        'required' => false,
                        'default' => [],
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockComponent::DEFAULT_CONFIG,
                        'type' => 'array',
                        'label' => 'Default Config',
                        'required' => false,
                        'default' => [],
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockComponent::CACHEABLE,
                        'type' => 'bool',
                        'label' => 'Cachable',
                        'required' => false,
                        'default' => false,
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockComponent::RENDERER,
                        'type' => 'zrcms-service',
                        'label' => 'Renderer',
                        'required' => false,
                        'default' => 'mustache',
                        'options' => [
                            ValidateIsZrcmsServiceAlias::OPTION_SERVICE_ALIAS_NAMESPACE
                            => ServiceAliasBlock::ZRCMS_CONTENT_RENDERER
                        ],
                    ],
                    [
                        'name' => FieldsBlockComponent::DATA_PROVIDER,
                        'type' => 'zrcms-service',
                        'label' => 'Data Provider',
                        'required' => false,
                        'default' => 'noop',
                        'options' => [
                            ValidateIsZrcmsServiceAlias::OPTION_SERVICE_ALIAS_NAMESPACE
                            => ServiceAliasBlock::ZRCMS_CONTENT_DATA_PROVIDER
                        ],
                    ],
                    [
                        'name' => FieldsBlockComponent::FIELDS,
                        'type' => 'fields',
                        'label' => 'Fields',
                        'required' => false,
                        'default' => [],
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockComponent::TEMPLATE_FILE,
                        'type' => 'string',
                        'label' => 'Template File',
                        'required' => false,
                        'default' => [],
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockComponent::DISABLED,
                        'type' => 'bool',
                        'label' => 'Disabled',
                        'required' => false,
                        'default' => false,
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockComponent::ICON,
                        'type' => 'text',
                        'label' => 'Icon Path',
                        'required' => false,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockComponent::EDITOR,
                        'type' => 'text',
                        'label' => 'Client Editor',
                        'required' => false,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockComponent::CATEGORY,
                        'type' => 'text',
                        'label' => 'Type',
                        'required' => false,
                        'default' => 'General',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockComponent::LABEL,
                        'type' => 'text',
                        'label' => 'Label',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockComponent::DESCRIPTION,
                        'type' => 'text',
                        'label' => 'Description',
                        'required' => false,
                        'default' => '',
                        'options' => [],
                    ],
                ],
                FieldsBlockComponentConfig::FIELD_MODEL_NAME => [
                    [
                        'name' => FieldsBlockComponentConfig::TYPE,
                        'type' => 'text',
                        'label' => 'Component Type',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockComponentConfig::NAME,
                        'type' => 'text',
                        'label' => 'Name',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockComponentConfig::CREATED_BY_USER_ID,
                        'type' => 'string',
                        'label' => 'Created By User ID',
                        'required' => false,
                        'default' => Trackable::UNKNOWN_USER_ID,
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockComponentConfig::CREATED_REASON,
                        'type' => 'string',
                        'label' => 'Created Reason',
                        'required' => false,
                        'default' => Trackable::UNKNOWN_REASON,
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockComponentConfig::COMPONENT_CONFIG_READER,
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
                        'name' => FieldsBlockComponentConfig::COMPONENT_CLASS,
                        'type' => 'class',
                        'label' => 'Component Class',
                        'required' => false,
                        'default' => BlockComponentBasic::class,
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockComponentConfig::DEFAULT_CONFIG,
                        'type' => 'array',
                        'label' => 'Default Config',
                        'required' => false,
                        'default' => [],
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockComponentConfig::CACHEABLE,
                        'type' => 'bool',
                        'label' => 'Cachable',
                        'required' => false,
                        'default' => false,
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockComponentConfig::RENDERER,
                        'type' => 'zrcms-service',
                        'label' => 'Renderer',
                        'required' => false,
                        'default' => 'mustache',
                        'options' => [
                            ValidateIsZrcmsServiceAlias::OPTION_SERVICE_ALIAS_NAMESPACE
                            => ServiceAliasBlock::ZRCMS_CONTENT_RENDERER
                        ],
                    ],
                    [
                        'name' => FieldsBlockComponentConfig::DATA_PROVIDER,
                        'type' => 'zrcms-service',
                        'label' => 'Data Provider',
                        'required' => false,
                        'default' => 'noop',
                        'options' => [
                            ValidateIsZrcmsServiceAlias::OPTION_SERVICE_ALIAS_NAMESPACE
                            => ServiceAliasBlock::ZRCMS_CONTENT_DATA_PROVIDER
                        ],
                    ],
                    [
                        'name' => FieldsBlockComponentConfig::FIELDS,
                        'type' => 'fields',
                        'label' => 'Fields',
                        'required' => false,
                        'default' => [],
                        'options' => [
                            //'fields-config' => [/* Details required */],
                        ],
                    ],
                    [
                        'name' => FieldsBlockComponentConfig::TEMPLATE_FILE,
                        'type' => 'string',
                        'label' => 'Template File',
                        'required' => false,
                        'default' => [],
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockComponentConfig::ICON,
                        'type' => 'text',
                        'label' => 'Icon Path',
                        'required' => false,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockComponentConfig::EDITOR,
                        'type' => 'text',
                        'label' => 'Client Editor',
                        'required' => false,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockComponentConfig::CATEGORY,
                        'type' => 'text',
                        'label' => 'Category',
                        'required' => false,
                        'default' => 'General',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockComponentConfig::LABEL,
                        'type' => 'text',
                        'label' => 'Label',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockComponentConfig::DESCRIPTION,
                        'type' => 'text',
                        'label' => 'Description',
                        'required' => false,
                        'default' => '',
                        'options' => [],
                    ],
                ],
                FieldsBlockVersion::FIELD_MODEL_NAME => [
                    [
                        'name' => FieldsBlockVersion::CONTAINER_VERSION_ID,
                        'type' => 'string',
                        'label' => 'Container Version Id',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockVersion::BLOCK_COMPONENT_NAME,
                        'type' => 'string',
                        'label' => 'Block Component Name',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockVersion::CONFIG,
                        'type' => 'array',
                        'label' => 'Config',
                        'required' => false,
                        'default' => [],
                        'options' => [],
                    ],
                    [
                        'name' => FieldsBlockVersion::LAYOUT_PROPERTIES,
                        'type' => 'fields',
                        'label' => 'Layout Properties',
                        'required' => true,
                        'default' => [],
                        'options' => [
                            'fields-config' => [
                                [
                                    'name' => FieldsBlockVersion::LAYOUT_PROPERTIES_RENDER_ORDER,
                                    'type' => 'int',
                                    'label' => 'Render Order',
                                    'required' => true,
                                    'default' => 0,
                                    'options' => [],
                                ],
                                [
                                    'name' => FieldsBlockVersion::LAYOUT_PROPERTIES_ROW_NUMBER,
                                    'type' => 'int',
                                    'label' => 'Row Number',
                                    'required' => true,
                                    'default' => 0,
                                    'options' => [],
                                ],
                                [
                                    'name' => FieldsBlockVersion::LAYOUT_PROPERTIES_COLUMN_CLASS,
                                    'type' => 'string',
                                    'label' => 'Column CSS Class',
                                    'required' => false,
                                    'default' => '',
                                    'options' => [],
                                ],
                            ]
                        ],
                    ],
                ],
            ],

            /**
             * ===== Service Alias =====
             */
            'zrcms-service-alias' => [
                ServiceAliasComponent::ZRCMS_COMPONENT_CONFIG_READER => [
                    ReadComponentConfigBlockBc::SERVICE_ALIAS
                    => ReadComponentConfigBlockBc::class,

                    ReadComponentConfigJsonFile::SERVICE_ALIAS
                    => ReadComponentConfigJsonFile::class,

                    ReadComponentConfigJsonFileBc::SERVICE_ALIAS
                    => ReadComponentConfigJsonFileBc::class,
                ],
                // 'zrcms.block.content.renderer'
                ServiceAliasBlock::ZRCMS_CONTENT_RENDERER => [
                    'mustache' // RenderBlockMustache::SERVICE_ALIAS
                    => RenderBlockMustache::class,

                    RenderBlockBc::SERVICE_ALIAS
                    => RenderBlockBc::class,
                ],
                // 'zrcms.block.content.data-provider'
                ServiceAliasBlock::ZRCMS_CONTENT_DATA_PROVIDER => [
                    'noop'
                    => GetBlockDataNoop::class,
                ],
            ],
            /**
             * ===== ZRCMS Types =====
             */
            'zrcms-component-types' => [
                'block' => [
                    'component-model-interface' => BlockComponent::class,
                    'component-model-class' => BlockComponentBasic::class,
                ]
            ],
        ];
    }
}
