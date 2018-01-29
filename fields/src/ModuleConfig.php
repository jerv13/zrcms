<?php

namespace Zrcms\Fields;

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
use Zrcms\Fields\Api\PrepareFieldsByFieldsModelNameFactory;
use Zrcms\Fields\Api\ValidateByFieldConfigValidator;
use Zrcms\Fields\Api\ValidateByFieldConfigValidatorFactory;
use Zrcms\Fields\Api\ValidateByFieldType;
use Zrcms\Fields\Api\ValidateByFieldTypeFactory;
use Zrcms\Fields\Api\ValidateByFieldTypeRequired;
use Zrcms\Fields\Api\ValidateByFieldTypeRequiredFactory;
use Zrcms\Fields\Api\ValidateFieldsByFieldsModelName;
use Zrcms\Fields\Api\ValidateFieldsByFieldsModelNameFactory;

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
                        'factory' => PrepareFieldsByFieldsModelNameFactory::class,
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
                    ValidateFieldsByFieldsModelName::class => [
                        'factory' => ValidateFieldsByFieldsModelNameFactory::class,
                    ],
                ],
            ],
        ];
    }
}
