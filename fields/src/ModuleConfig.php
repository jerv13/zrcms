<?php

namespace Zrcms\Fields;

use Zrcms\CoreSite\Fields\FieldsSiteVersion;
use Zrcms\InputValidation\Api\ValidateFieldsByStrategy;
use Zrcms\InputValidation\Api\ValidateIsArray;
use Zrcms\InputValidation\Api\ValidateIsBoolean;
use Zrcms\InputValidation\Api\ValidateIsClass;
use Zrcms\InputValidation\Api\ValidateIsObject;
use Zrcms\InputValidation\Api\ValidateIsString;
use Zrcms\InputValidationZrcms\Api\ValidateIsZrcmsServiceAlias;

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
            /**
             * ===== ZRCMS Fields =====
             */
            'zrcms-fields' => [
                FieldsSiteVersion::class => [
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
                        'options' => [],
                    ],
                ],
            ],

            'zrcms-field-types' => [
                'array' => [
                    'validator' => ValidateIsArray::class,
                    'validator-options' => [],
                ],
                'bool' => [
                    'validator' => ValidateIsBoolean::class,
                    'validator-options' => [],
                ],
                'class' => [
                    'validator' => ValidateIsClass::class,
                    'validator-options' => [],
                ],
                'fields' => [
                    'validator' => ValidateFieldsByStrategy::class,
                    'validator-options' => [],
                ],
                'id' => [
                    'validator' => ValidateIsString::class,
                    'validator-options' => [],
                ],
                'object' => [
                    'validator' => ValidateIsObject::class,
                    'validator-options' => [],
                ],
                'text' => [
                    'validator' => ValidateIsString::class,
                    'validator-options' => [],
                ],
                'string' => [
                    'validator' => ValidateIsString::class,
                    'validator-options' => [],
                ],
                'zrcms-service' => [
                    'validator' => ValidateIsZrcmsServiceAlias::class,
                    'validator-options' => [],
                ],
            ],
        ];
    }
}
