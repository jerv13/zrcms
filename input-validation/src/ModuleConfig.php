<?php

namespace Zrcms\InputValidation;

use Zrcms\InputValidation\Api\ValidateByStrategy;
use Zrcms\InputValidation\Api\ValidateByStrategyFactory;
use Zrcms\InputValidation\Api\ValidateCompositeByStrategy;
use Zrcms\InputValidation\Api\ValidateCompositeByStrategyFactory;
use Zrcms\InputValidation\Api\ValidateFieldsByStrategy;
use Zrcms\InputValidation\Api\ValidateFieldsByStrategyFactory;
use Zrcms\InputValidation\Api\ValidateIsArray;
use Zrcms\InputValidation\Api\ValidateIsArrayFactory;
use Zrcms\InputValidation\Api\ValidateIsAssociativeArray;
use Zrcms\InputValidation\Api\ValidateIsAssociativeArrayFactory;
use Zrcms\InputValidation\Api\ValidateIsBoolean;
use Zrcms\InputValidation\Api\ValidateIsBooleanFactory;
use Zrcms\InputValidation\Api\ValidateIsAnyValue;
use Zrcms\InputValidation\Api\ValidateIsAnyValueFactory;
use Zrcms\InputValidation\Api\ValidateIsNotEmpty;
use Zrcms\InputValidation\Api\ValidateISNotEmptyFactory;
use Zrcms\InputValidation\Api\ValidateIsNull;
use Zrcms\InputValidation\Api\ValidateIsNullFactory;
use Zrcms\InputValidation\Api\ValidateIsString;
use Zrcms\InputValidation\Api\ValidateIsStringFactory;
use Zrcms\InputValidation\Api\ValidateIsValue;
use Zrcms\InputValidation\Api\ValidateIsValueFactory;
use Zrcms\InputValidation\Api\ValidationFieldsResultToArray;
use Zrcms\InputValidation\Api\ValidationFieldsResultToArrayBasicFactory;
use Zrcms\InputValidation\Api\ValidationResultToArray;
use Zrcms\InputValidation\Api\ValidationResultToArrayBasicFactory;

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
                    ValidateByStrategy::class => [
                        'factory' => ValidateByStrategyFactory::class,
                    ],

                    ValidateCompositeByStrategy::class => [
                        'factory' => ValidateCompositeByStrategyFactory::class,
                    ],

                    ValidateFieldsByStrategy::class => [
                        'factory' => ValidateFieldsByStrategyFactory::class,
                    ],

                    ValidateIsAnyValue::class => [
                        'factory' => ValidateIsAnyValueFactory::class,
                    ],
                    ValidateIsArray::class => [
                        'factory' => ValidateIsArrayFactory::class,
                    ],
                    ValidateIsAssociativeArray::class => [
                        'factory' => ValidateIsAssociativeArrayFactory::class,
                    ],
                    ValidateIsBoolean::class => [
                        'factory' => ValidateIsBooleanFactory::class,
                    ],
                    ValidateIsNotEmpty::class => [
                        'factory' => ValidateISNotEmptyFactory::class,
                    ],
                    ValidateIsNull::class => [
                        'factory' => ValidateIsNullFactory::class,
                    ],
                    ValidateIsString::class => [
                        'factory' => ValidateIsStringFactory::class,
                    ],
                    ValidateIsValue::class => [
                        'factory' => ValidateIsValueFactory::class,
                    ],

                    ValidationFieldsResultToArray::class => [
                        'factory' => ValidationFieldsResultToArrayBasicFactory::class,
                    ],

                    ValidationResultToArray::class => [
                        'factory' => ValidationResultToArrayBasicFactory::class,
                    ],
                ],
            ],
        ];
    }
}
