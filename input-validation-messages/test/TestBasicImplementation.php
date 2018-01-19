<?php

namespace Zrcms\InputValidationMessages\Test;

use Zrcms\InputValidation\Api\ValidationResultFieldsToArrayBasic;
use Zrcms\InputValidation\Api\ValidationResultToArrayBasic;
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
        $validationResultFields = new ValidationResultFieldsBasic(
            false,
            'root',
            ['test' => 'detail-root'],
            [
                'field-1' => new ValidationResultBasic(
                    false,
                    'code-1',
                    ['test' => 'detail-1']
                ),
                'field-2' => new ValidationResultBasic(
                    true,
                    '',
                    ['test' => 'detail-2']
                ),
                'field-4' => new ValidationResultBasic(
                    false,
                    'code-4',
                    ['test' => 'detail-4']
                ),
                'field-5' => new ValidationResultBasic(
                    false,
                    'code-5',
                    ['test' => 'detail-5']
                ),
                'field-5n' => new ValidationResultBasic(
                    false,
                    'code-5',
                    ['test' => 'detail-5']
                ),
                'field-3' => new ValidationResultFieldsBasic(
                    false,
                    'root',
                    ['test' => 'detail-3'],
                    [
                        'field-3-a' => new ValidationResultBasic(
                            false,
                            'code-3-a',
                            ['test' => 'detail-3-a']
                        ),
                        'field-3-b' => new ValidationResultBasic(
                            false,
                            'code-3-b',
                            ['test' => 'detail-3-b']
                        ),
                        'field-3-c' => new ValidationResultBasic(
                            false,
                            'code-3-c',
                            ['test' => 'detail-3-c']
                        ),
                        'field-3-5' => new ValidationResultBasic(
                            false,
                            'code-5',
                            ['test' => 'detail-5']
                        ),
                        'field-3-d' => new ValidationResultFieldsBasic(
                            false,
                            'root',
                            ['test' => 'detail-3-d'],
                            [
                                'field-3-d-1' => new ValidationResultBasic(
                                    false,
                                    'code-3-d-1',
                                    ['test' => 'detail-3-d-1']
                                ),
                                'field-3-d-2' => new ValidationResultBasic(
                                    false,
                                    'code-3-d-2',
                                    ['test' => 'detail-3-d-2']
                                ),
                                'field-3-d-3' => new ValidationResultBasic(
                                    true,
                                    '',
                                    ['test' => 'detail-d-3']
                                )
                            ]
                        ),
                    ]
                ),
            ]
        );

        $codeMessages = [
            'code-1' => 'Code Field One Message with param ({test-param})',
            'code-2' => 'Code Field Two Message',
            'code-3' => 'Code Field Three Message',
            'code-5' => [
                '__default' => 'Default code-5 message',
                'field-5' => 'Code Field Five Message'
            ],
            'code-3-a' => 'Code Field Three A Message',
            'code-3-b' => 'Code Field Three B Message',
            'code-3-c' => 'Code Field Three C Message',
        ];

        $getMessagesValidationResult= new GetMessagesValidationResultBasic(
            $codeMessages,
            'DEFAULT MESSAGE'
        );

        $getMessagesValidationResultFields = new GetMessagesValidationResultFieldsBasic(
            $getMessagesValidationResult,
            $codeMessages,
            'DEFAULT MESSAGE'
        );

        $messages = $getMessagesValidationResultFields->__invoke(
            $validationResultFields,
            [
                GetMessagesValidationResult::OPTION_MESSAGE_PARAMS => ['test-param' => 'Test Param WORKS!']
            ]
        );

        $output = "\nValidationResult:\n";
        $output .= "\n" . json_encode(self::getResultArray($validationResultFields), JSON_PRETTY_PRINT) . "\n";
        $output .= "\nMessages:\n";
        $output .= "\n" . json_encode($messages, JSON_PRETTY_PRINT) . "\n";

        var_dump($output);
    }

    /**
     * @param $validationResultFields
     *
     * @return array
     */
    protected static function getResultArray(
        $validationResultFields
    ) {
        $validationResultToArray = new ValidationResultToArrayBasic();

        $validationResultFieldsToArray = new ValidationResultFieldsToArrayBasic(
            $validationResultToArray
        );

        return $validationResultFieldsToArray->__invoke(
            $validationResultFields
        );
    }
}
