<?php

namespace Zrcms\InputValidation\Api;

use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\InputValidation\Model\ValidationResultBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateIsArray implements Validate
{
    const CODE_MUST_BE_ARRAY = 'must-be-array';

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

        return new ValidationResultBasic();
    }
}
