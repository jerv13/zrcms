<?php

namespace Zrcms\InputValidation\Api;

use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\InputValidation\Model\ValidationResultBasic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateIsAssociativeArray implements Validate
{
    const CODE_MUST_BE_ARRAY = ValidateIsArray::CODE_MUST_BE_ARRAY;
    const CODE_MUST_BE_ASSOCIATIVE_ARRAY = 'must-be-associative-array';

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
        if (!is_array($value)) {
            return new ValidationResultBasic(
                false,
                static::CODE_MUST_BE_ARRAY
            );
        }

        if (!(array_keys($value) !== range(0, count($value) - 1))) {
            return new ValidationResultBasic(
                false,
                static::CODE_MUST_BE_ASSOCIATIVE_ARRAY
            );
        }

        return new ValidationResultBasic();
    }
}
