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

            /**
             * ===== ZRCMS Input Validation Messages =====
             * [
             *    '{code-1}' => 'code-1 Message with param ({test-param})',
             *    '{code-2}' => [
             *       '__default' => 'Default code-2 message',
             *       '{field-name}' => 'Field code-2 message'
             *    ],
             * ],
             */
            'zrcms-input-validation-messages' => [],
        ];
    }
}
