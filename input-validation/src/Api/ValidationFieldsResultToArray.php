<?php

namespace Zrcms\InputValidation\Api;

use Zrcms\InputValidation\Model\ValidationResultFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ValidationFieldsResultToArray
{
    /**
     * @param ValidationResultFields $validationResultFields
     * @param array                  $options
     *
     * @return array
     */
    public function __invoke(
        ValidationResultFields $validationResultFields,
        array $options = []
    ): array;
}
