<?php

namespace Zrcms\Fields;

use Zrcms\CoreSite\Fields\FieldsSiteVersion;
use Zrcms\Fields\Api\Field\FieldsToArray;
use Zrcms\Fields\Api\Field\FieldsToArrayBasicFactory;
use Zrcms\Fields\Api\Field\FieldToArray;
use Zrcms\Fields\Api\Field\FieldToArrayBasicFactory;
use Zrcms\Fields\Api\Field\FindFieldsByModel;
use Zrcms\Fields\Api\Field\FindFieldsByModelBasicFactory;
use Zrcms\Fields\Api\FieldType\FieldTypeToArray;
use Zrcms\Fields\Api\FieldType\FieldTypeToArrayBasicFactory;
use Zrcms\Fields\Api\FieldType\FindFieldType;
use Zrcms\Fields\Api\FieldType\FindFieldTypeBasicFactory;
use Zrcms\Fields\Api\FieldType\ListFieldTypes;
use Zrcms\Fields\Api\FieldType\ListFieldTypesBasicFactory;
use Zrcms\Fields\Api\PrepareFields;
use Zrcms\Fields\Api\PrepareFieldsByFieldsConfigFactory;
use Zrcms\Fields\Api\ValidateByFieldConfigValidator;
use Zrcms\Fields\Api\ValidateByFieldConfigValidatorFactory;
use Zrcms\Fields\Api\ValidateByFieldType;
use Zrcms\Fields\Api\ValidateByFieldTypeFactory;
use Zrcms\Fields\Api\ValidateByFieldTypeRequired;
use Zrcms\Fields\Api\ValidateByFieldTypeRequiredFactory;
use Zrcms\Fields\Api\ValidateFieldsByFieldsConfig;
use Zrcms\Fields\Api\ValidateFieldsByFieldsConfigFactory;
use Zrcms\InputValidation\Api\ValidateFieldsByStrategy;
use Zrcms\InputValidation\Api\ValidateIsArray;
use Zrcms\InputValidation\Api\ValidateIsBoolean;
use Zrcms\InputValidation\Api\ValidateIsClass;
use Zrcms\InputValidation\Api\ValidateIsObject;
use Zrcms\InputValidation\Api\ValidateIsRealValue;
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
            'dependencies' => [
                'config_factories' => [
                    FieldsToArray::class => [
                        'factory' => FieldsToArrayBasicFactory::class,
                    ],
                    FieldToArray::class => [
                        'factory' => FieldToArrayBasicFactory::class,
                    ],
                    FindFieldsByModel::class => [
                        'factory' => FindFieldsByModelBasicFactory::class,
                    ],
                    FieldTypeToArray::class => [
                        'factory' => FieldTypeToArrayBasicFactory::class,
                    ],
                    FindFieldType::class => [
                        'factory' => FindFieldTypeBasicFactory::class,
                    ],
                    ListFieldTypes::class => [
                        'factory' => ListFieldTypesBasicFactory::class,
                    ],
                    PrepareFields::class => [
                        'factory' => PrepareFieldsByFieldsConfigFactory::class,
                    ],
                    ValidateByFieldConfigValidator::class => [
                        'factory' => ValidateByFieldConfigValidatorFactory::class,
                    ],
                    ValidateByFieldType::class => [
                        'factory' => ValidateByFieldTypeFactory::class,
                    ],
                    ValidateByFieldTypeRequired::class => [
                        'factory' => ValidateByFieldTypeRequiredFactory::class,
                    ],
                    ValidateFieldsByFieldsConfig::class => [
                        'factory' => ValidateFieldsByFieldsConfigFactory::class,
                    ],
                ],
            ],

            /**
             * ===== ZRCMS Field Models =====
             * ['{model-name}' => '{model-class}']
             */
            'zrcms-fields-model' => [
            ],

            /**
             * ===== ZRCMS Fields =====
             * ['{model-name}' => '{fields-config}']
             */
            'zrcms-fields' => [
            ],

            /**
             * ===== ZRCMS Field Types =====
             */
            'zrcms-field-types' => [
                'array' => [
                    'validator' => ValidateIsArray::class,
                    'validator-options' => [],
                    'validator-required' => ValidateIsRealValue::class,
                    'validator-required-options' => [],
                ],
                'bool' => [
                    'validator' => ValidateIsBoolean::class,
                    'validator-options' => [],
                    'validator-required' => ValidateIsRealValue::class,
                    'validator-required-options' => [],
                ],
                'class' => [
                    'validator' => ValidateIsClass::class,
                    'validator-options' => [],
                    'validator-required' => ValidateIsRealValue::class,
                    'validator-required-options' => [],
                ],
                'fields' => [
                    'validator' => ValidateFieldsByStrategy::class,
                    'validator-options' => [],
                    'validator-required' => ValidateIsRealValue::class,
                    'validator-required-options' => [],
                ],
                'id' => [
                    'validator' => ValidateIsString::class,
                    'validator-options' => [],
                    'validator-required' => ValidateIsRealValue::class,
                    'validator-required-options' => [],
                ],
                'object' => [
                    'validator' => ValidateIsObject::class,
                    'validator-options' => [],
                    'validator-required' => ValidateIsRealValue::class,
                    'validator-required-options' => [],
                ],
                'text' => [
                    'validator' => ValidateIsString::class,
                    'validator-options' => [],
                    'validator-required' => ValidateIsRealValue::class,
                    'validator-required-options' => [],
                ],
                'string' => [
                    'validator' => ValidateIsString::class,
                    'validator-options' => [],
                    'validator-required' => ValidateIsRealValue::class,
                    'validator-required-options' => [],
                ],
                'zrcms-service' => [
                    'validator' => ValidateIsZrcmsServiceAlias::class,
                    'validator-options' => [],
                    'validator-required' => ValidateIsRealValue::class,
                    'validator-required-options' => [],
                ],
            ],
        ];
    }
}
