<?php

namespace Zrcms\HttpStatusPages;

use Zrcms\Core\Fields\FieldsComponentConfig;
use Zrcms\Core\Model\ComponentBasic;
use Zrcms\Core\Model\ServiceAliasComponent;
use Zrcms\HttpStatusPages\Fields\FieldsHttpStatusPagesComponent;
use Zrcms\HttpStatusPages\Model\HttpStatusPagesComponent;
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
            'zrcms-components' => [
                'basic.zrcms-http-status-pages' => 'app-config:zrcms-http-status-pages',
            ],

            /**
             * ===== Field Models =====
             * ['{model-name}' => '{model-class}']
             */
            'field-rat-fields-model' => [
                FieldsHttpStatusPagesComponent::FIELD_MODEL_NAME => FieldsHttpStatusPagesComponent::class,
            ],

            /**
             * ===== Field Model Extends =====
             * ['{model-name}' => '{extends-model-name}']
             */
            'field-rat-fields-model-extends' => [
                FieldsHttpStatusPagesComponent::FIELD_MODEL_NAME => 'component',
            ],

            /**
             * ===== Fields =====
             * ['{model-name}' => '{fields-config}']
             */
            'field-rat-fields' => [
                FieldsHttpStatusPagesComponent::FIELD_MODEL_NAME => [
                    [
                        'name' => FieldsHttpStatusPagesComponent::COMPONENT_CONFIG_READER,
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
                        'name' => FieldsHttpStatusPagesComponent::COMPONENT_CLASS,
                        'type' => 'class',
                        'label' => 'Component Class',
                        'required' => false,
                        'default' => ComponentBasic::class,
                        'options' => [],
                    ],
                    [
                        'name' => FieldsHttpStatusPagesComponent::STATUS_TO_SITE_PATH_PROPERTY,
                        'type' => 'array',
                        'label' => 'Map of HTTP status to the path and a type',
                        'required' => false,
                        'default' => [],
                        'options' => [],
                    ],
                ],
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
