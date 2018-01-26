<?php

namespace Zrcms\InputValidationMessages;

use Zrcms\InputValidationMessages\Api\GetMessagesValidationResult;
use Zrcms\InputValidationMessages\Api\GetMessagesValidationResultBasicFactory;
use Zrcms\InputValidationMessages\Api\GetMessagesValidationResultFields;
use Zrcms\InputValidationMessages\Api\GetMessagesValidationResultFieldsBasicFactory;

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
                    GetMessagesValidationResult::class => [
                        'factory' => GetMessagesValidationResultBasicFactory::class
                    ],
                    GetMessagesValidationResultFields::class => [
                        'factory' => GetMessagesValidationResultFieldsBasicFactory::class
                    ],
                ],
            ],
        ];
    }
}
