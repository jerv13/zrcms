<?php

namespace Zrcms\InputValidationMessages\Api;

use Zrcms\InputValidation\Model\ValidationResultFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetMessagesValidationResultFields
{
    const KEY_FIELD_NAME = GetMessagesValidationResult::KEY_FIELD_NAME;

    /**
     * @param ValidationResultFields $validationResultFields
     * @param array                  $options
     *
     * @return  array ['{field-name}' => ['{code}' => '{message}']]
     */
    public function __invoke(
        ValidationResultFields $validationResultFields,
        array $options = []
    ): array;
}
