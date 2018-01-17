<?php

namespace Zrcms\InputValidationZrcms\Api;

use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\InputValidation\Model\ValidationResultBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateIdBasic implements ValidateId
{
    const CODE_EMPTY_ID = 'Id con not be empty';
    const CODE_NOT_STRING = 'Id must be string';

    /**
     * @param mixed $id
     * @param array $options
     *
     * @return ValidationResult
     */
    public function __invoke(
        $id,
        array $options = []
    ): ValidationResult {
        if (empty($id)) {
            return new ValidationResultBasic(
                false,
                static::CODE_EMPTY_ID
            );
        }

        if (!is_string($id)) {
            return new ValidationResultBasic(
                false,
                static::CODE_NOT_STRING
            );
        }

        // @todo More security checks

        return new ValidationResultBasic();
    }
}
