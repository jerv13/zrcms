<?php

namespace Zrcms\InputValidationMessages\Api;

use Zrcms\InputValidation\Model\ValidationResultFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface GetMessagesValidationResultFields
{
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
