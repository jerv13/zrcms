<?php

namespace Zrcms\Fields;

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
            'zrcms-fields-model' => [],

            /**
             * ===== ZRCMS Field Model Extends =====
             * ['{model-name}' => '{extends-model-name}']
             */
            'zrcms-fields-model-extends' => [],

            /**
             * ===== ZRCMS Fields =====
             * ['{model-name}' => '{fields-config}']
             */
            'zrcms-fields' => [],

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
