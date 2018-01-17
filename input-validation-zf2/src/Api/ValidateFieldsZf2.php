<?php

namespace Zrcms\InputValidationZf2\Api;

use Zrcms\InputValidation\Api\ValidateFields;
use Zrcms\InputValidation\Model\ValidationResultFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateFieldsZf2 implements ValidateFields
{
    public function __invoke(
        array $fields,
        array $options = []
    ): ValidationResultFields {
        // TODO: Implement __invoke() method.
    }
}
