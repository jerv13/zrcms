<?php

namespace Zrcms\InputValidationMessages\Api;

use Zrcms\InputValidation\Model\ValidationResult;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetMessagesValidationResult
{
    const OPTION_MESSAGE_PARAMS = 'message-params';
    const KEY_CODE = 'code';
    const KEY_MESSAGE = 'message';
    const KEY_FIELD_NAME = 'field-name';
    const KEY_DEFAULT = '__default';

    /**
     * @param ValidationResult $validationResult
     * @param array            $options
     *
     * @return array ['{code}' => '{message}']
     */
    public function __invoke(
        ValidationResult $validationResult,
        array $options = []
    ): array;
}
