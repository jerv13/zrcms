<?php

namespace Zrcms\CoreApplication;

use Zrcms\Core\Api\Component\BuildComponentObject;
use Zrcms\Core\Fields\FieldsComponent;
use Zrcms\Core\Fields\FieldsComponentConfig;
use Zrcms\Core\Fields\FieldsContent;
use Zrcms\Core\Fields\FieldsContentVersion;
use Zrcms\Core\Model\Component;
use Zrcms\Core\Model\ComponentBasic;
use Zrcms\Core\Model\ServiceAliasComponent;
use Zrcms\Core\Model\Trackable;
use Zrcms\CoreApplication\Api\Component\BuildComponentObjectByType;
use Zrcms\CoreApplication\Api\Component\ReadComponentConfigApplicationConfig;
use Zrcms\CoreApplication\Api\Component\ReadComponentConfigCallable;
use Zrcms\CoreApplication\Api\Component\ReadComponentConfigJsonFile;
use Zrcms\CoreApplication\Api\Component\ReadComponentConfigPhpFile;
use Zrcms\CoreApplication\Api\Component\ReadComponentRegistryBasic;

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
             * ===== ZRCMS Component Registry =====
             */
            'zrcms-components' => [
                /* '{type.name}' => '{config-location}' */
            ],

            /**
             * ===== ZRCMS Component Registry Readers =====
             */
            'zrcms-component-registry-readers' => [
                /* '{service-name}' => '{service-name}' */
                ReadComponentRegistryBasic::class => ReadComponentRegistryBasic::class,
            ],

            /**
             * ===== Field Models =====
             * ['{model-name}' => '{model-class}']
             */
            'field-rat-fields-model' => [
                'component' => FieldsComponent::class,
                'component-config' => FieldsComponentConfig::class,
                'content' => FieldsContent::class,
                'content-version' => FieldsContentVersion::class,
            ],

            /**
             * ===== Fields =====
             * ['{model-name}' => '{fields-config}']
             */
            'field-rat-fields' => [
                FieldsComponent::FIELD_MODEL_NAME => [
                    [
                        'name' => FieldsComponent::COMPONENT_CONFIG_READER,
                        'type' => 'zrcms-service',
                        'label' => 'Component Config Reader',
                        'required' => false,
                        'default' => 'json',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsComponent::COMPONENT_CLASS,
                        'type' => 'class',
                        'label' => 'Component Class',
                        'required' => false,
                        'default' => ComponentBasic::class,
                        'options' => [],
                    ],
                    [
                        'name' => FieldsComponent::JAVASCRIPT,
                        'type' => 'array',
                        'label' => 'Javascript Includes',
                        'required' => false,
                        'default' => [],
                        'options' => [],
                    ],
                    [
                        'name' => FieldsComponent::CSS,
                        'type' => 'array',
                        'label' => 'CSS Includes',
                        'required' => false,
                        'default' => [],
                        'options' => [],
                    ],
                ],
                'component-config' => [
                    [
                        'name' => FieldsComponentConfig::TYPE,
                        'type' => 'text',
                        'label' => 'Component Type',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsComponentConfig::NAME,
                        'type' => 'text',
                        'label' => 'Name',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsComponentConfig::CONFIG_URI,
                        'type' => 'text',
                        'label' => 'Config Location (usually a path or application config key)',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsComponentConfig::MODULE_DIRECTORY,
                        'type' => 'text',
                        'label' => 'Module Directory (module directory for component files)',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsComponentConfig::CREATED_BY_USER_ID,
                        'type' => 'zrcms-service',
                        'label' => 'Created By User ID',
                        'required' => false,
                        'default' => Trackable::UNKNOWN_USER_ID,
                        'options' => [],
                    ],
                    [
                        'name' => FieldsComponentConfig::CREATED_REASON,
                        'type' => 'class',
                        'label' => 'Component Class',
                        'required' => false,
                        'default' => Trackable::UNKNOWN_REASON,
                        'options' => [],
                    ],
                    [
                        'name' => FieldsComponentConfig::CREATED_DATE,
                        'type' => 'string',
                        'label' => 'Created Date',
                        'required' => false,
                        'default' => null, // This should be and empty string, but might cause issues
                        'options' => [],
                    ],
                    [
                        'name' => FieldsComponentConfig::COMPONENT_CONFIG_READER,
                        'type' => 'zrcms-service',
                        'label' => 'Component Config Reader',
                        'required' => false,
                        'default' => 'json',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsComponentConfig::COMPONENT_CLASS,
                        'type' => 'class',
                        'label' => 'Component Class',
                        'required' => false,
                        'default' => ComponentBasic::class,
                        'options' => [],
                    ],
                ],
                'content' => [],
                'content-version' => [],
            ],

            /**
             * ===== Service Alias =====
             */
            'zrcms-service-alias' => [
                // 'zrcms.basic.component.config-reader'
                ServiceAliasComponent::ZRCMS_COMPONENT_CONFIG_READER => [
                    ReadComponentConfigApplicationConfig::SERVICE_ALIAS
                    => ReadComponentConfigApplicationConfig::class,

                    ReadComponentConfigCallable::SERVICE_ALIAS
                    => ReadComponentConfigCallable::class,

                    ReadComponentConfigJsonFile::SERVICE_ALIAS
                    => ReadComponentConfigJsonFile::class,

                    ReadComponentConfigPhpFile::SERVICE_ALIAS
                    => ReadComponentConfigPhpFile::class,
                ],
            ],

            /**
             * ===== ZRCMS Types =====
             */
            'zrcms-types' => [
                /* Default services and classes are defined here */
                'basic' => [
                    BuildComponentObject::class => BuildComponentObjectByType::class,
                    'component-model-interface' => Component::class,
                    'component-model-class' => ComponentBasic::class,
                ],
            ],
        ];
    }
}
