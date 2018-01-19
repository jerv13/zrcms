<?php

namespace Zrcms\InputValidationMessages\Test;

use Zrcms\InputValidation\Model\ValidationResultBasic;
use Zrcms\InputValidation\Model\ValidationResultFieldsBasic;
use Zrcms\InputValidationMessages\Api\GetMessagesValidationResult;
use Zrcms\InputValidationMessages\Api\GetMessagesValidationResultBasic;
use Zrcms\InputValidationMessages\Api\GetMessagesValidationResultFieldsBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class TestBasicImplementation
{
    /**
     * @return void
     */
    public static function test()
    {
        $validationResultFieldsBasic = new ValidationResultFieldsBasic(
            false,
            'root',
            ['test' => 'detail-root'],
            [
                'field-1' => new ValidationResultBasic(
                    false,
                    'code-field-1',
                    ['test' => 'detail-field-1']
                ),
                'field-2' => new ValidationResultBasic(
                    true,
                    '',
                    ['test' => 'detail-field-2']
                ),
                'field-4' => new ValidationResultBasic(
                    false,
                    'code-field-4',
                    ['test' => 'detail-field-4']
                ),
                'field-3' => new ValidationResultFieldsBasic(
                    false,
                    'root',
                    ['test' => 'detail-field-3'],
                    [
                        'field-3-a' => new ValidationResultBasic(
                            false,
                            'code-field-3-a',
                            ['test' => 'detail-field-3-a']
                        ),
                        'field-3-b' => new ValidationResultBasic(
                            false,
                            'code-field-3-b',
                            ['test' => 'detail-field-3-b']
                        ),
                        'field-3-c' => new ValidationResultBasic(
                            false,
                            'code-field-3-c',
                            ['test' => 'detail-field-3-c']
                        ),
                        'field-3-d' => new ValidationResultFieldsBasic(
                            false,
                            'root',
                            ['test' => 'detail-field-3-d'],
                            [
                                'field-3-d-1' => new ValidationResultBasic(
                                    false,
                                    'code-field-3-d-1',
                                    ['test' => 'detail-field-3-d-1']
                                ),
                                'field-3-d-2' => new ValidationResultBasic(
                                    false,
                                    'code-field-3-d-2',
                                    ['test' => 'detail-field-3-d-2']
                                ),
                                'field-3-d-3' => new ValidationResultBasic(
                                    true,
                                    '',
                                    ['test' => 'detail-field-d-3']
                                )
                            ]
                        ),
                    ]
                ),
            ]
        );

        $codeMessages = [
            'code-field-1' => 'Code Field One Message with param ({test-param})',
            'code-field-2' => 'Code Field Two Message',
            'code-field-3' => 'Code Field Three Message',
            'code-field-3-a' => 'Code Field Three A Message',
            'code-field-3-b' => 'Code Field Three B Message',
            'code-field-3-c' => 'Code Field Three C Message',
        ];

        $getMessagesValidationResultBasic = new GetMessagesValidationResultBasic(
            $codeMessages,
            'DEFAULT MESSAGE'
        );

        $getMessagesValidationResultFieldsBasic = new GetMessagesValidationResultFieldsBasic(
            $getMessagesValidationResultBasic,
            $codeMessages,
            'DEFAULT MESSAGE'
        );

        $messages = $getMessagesValidationResultFieldsBasic->__invoke(
            $validationResultFieldsBasic,
            [
                GetMessagesValidationResult::OPTION_MESSAGE_PARAMS => ['test-param' => 'Test Param WORKS!']
            ]
        );

        var_dump(
            json_encode($messages, JSON_PRETTY_PRINT),
            $validationResultFieldsBasic
        );
    }
}
