<?php

namespace Zrcms\InputValidation;

use Zrcms\InputValidation\Api\ValidateId;
use Zrcms\InputValidation\Api\ValidateIdBasicFactory;
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
                    ValidateId::class => [
                        'factory' => ValidateIdBasicFactory::class,
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
