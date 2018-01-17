<?php

namespace Zrcms\InputValidation;

use Zrcms\InputValidation\Api\ValidateByStrategy;
use Zrcms\InputValidation\Api\ValidateByStrategyFactory;
use Zrcms\InputValidation\Api\ValidateFieldsByStrategy;
use Zrcms\InputValidation\Api\ValidateFieldsByStrategyFactory;
use Zrcms\InputValidation\Api\ValidateNoop;
use Zrcms\InputValidation\Api\ValidateNoopFactory;
use Zrcms\InputValidation\Api\ValidateNotEmpty;
use Zrcms\InputValidation\Api\ValidateNotEmptyFactory;
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

                    ValidateFieldsByStrategy::class => [
                        'factory' => ValidateFieldsByStrategyFactory::class,
                    ],

                    ValidateNoop::class => [
                        'factory' => ValidateNoopFactory::class,
                    ],

                    ValidateNotEmpty::class => [
                        'factory' => ValidateNotEmptyFactory::class,
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
