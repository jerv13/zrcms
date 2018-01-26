<?php

namespace Zrcms\InputValidation\Api;

use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\InputValidation\Model\ValidationResultBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateIsRealValue implements Validate
{
    const CODE_MUST_NOT_BE_EMPTY_STRING = 'must-not-be-empty-string';
    const CODE_MUST_NOT_BE_NULL = 'must-not-be-null';

    /**
     * @param mixed $value
     * @param array $options
     *
     * @return ValidationResult
     */
    public function __invoke(
        $value,
        array $options = []
    ): ValidationResult {
        if ($value === '') {
            return new ValidationResultBasic(
                false,
                static::CODE_MUST_NOT_BE_EMPTY_STRING
            );
        }

        if ($value === null) {
            return new ValidationResultBasic(
                false,
                static::CODE_MUST_NOT_BE_NULL
            );
        }

        return new ValidationResultBasic();
    }
}
