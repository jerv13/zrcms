<?php

namespace Zrcms\CoreSite;

use Zrcms\CoreSite\Fields\FieldsSiteVersion;

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
                FieldsSiteVersion::FIELD_MODEL_NAME => FieldsSiteVersion::class,
            ],

            /**
             * ===== Field Model Extends =====
             * ['{model-name}' => '{extends-model-name}']
             */
            'field-rat-fields-model-extends' => [
                FieldsSiteVersion::FIELD_MODEL_NAME => 'content-version',
            ],

            /**
             * ===== Fields =====
             * ['{model-name}' => '{fields-config}']
             */
            'field-rat-fields' => [
                FieldsSiteVersion::FIELD_MODEL_NAME => [
                    [
                        'name' => FieldsSiteVersion::HOST,
                        'type' => 'text',
                        'label' => 'Host/Domain',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsSiteVersion::THEME_NAME,
                        'type' => 'text',
                        'label' => 'Theme Name',
                        'required' => false,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsSiteVersion::LOCALE,
                        'type' => 'text',
                        'label' => 'Locale',
                        'required' => false,
                        'default' => 'en_US',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsSiteVersion::LAYOUT,
                        'type' => 'text',
                        'label' => 'Layout',
                        'required' => false,
                        'default' => FieldsSiteVersion::DEFAULT_PRIMARY_LAYOUT_NAME,
                        'options' => [],
                    ],
                    [
                        'name' => FieldsSiteVersion::COUNTRY_ISO3,
                        'type' => 'text',
                        'label' => 'Country ISO3 Code',
                        'required' => true,
                        'default' => 'USA',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsSiteVersion::LANGUAGE_ISO_939_2T,
                        'type' => 'text',
                        'label' => 'Language ISO 939 2t Code',
                        'required' => true,
                        'default' => 'eng',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsSiteVersion::TITLE,
                        'type' => 'text',
                        'label' => 'Site Title',
                        'required' => true,
                        'default' => '',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsSiteVersion::LOGIN_PAGE,
                        'type' => 'text',
                        'label' => 'Login Page Path',
                        'required' => false,
                        'default' => '/login',
                        'options' => [],
                    ],
                    [
                        'name' => FieldsSiteVersion::STATUS_PAGES,
                        'type' => 'array',
                        'label' => 'Status Pages Config',
                        'required' => false,
                        'default' => [
                            '401' => '/not-authorized',
                            '404' => '/not-found'
                        ],
                        'options' => [],
                    ],
                    [
                        'name' => FieldsSiteVersion::FAVICON,
                        'type' => 'text',
                        'label' => 'Favicon Path',
                        'required' => false,
                        'default' => null,
                        'options' => [
                            'type-validator-options' => []
                        ],
                    ],
                ],
            ],
            /**
             * ===== Service Alias =====
             */
            'zrcms-service-alias' => [

            ],
        ];
    }
}
