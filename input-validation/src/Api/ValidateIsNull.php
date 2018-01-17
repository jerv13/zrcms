<?php

namespace Zrcms\InputValidation\Api;

use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\InputValidation\Model\ValidationResultBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateIsNull implements Validate
{
    const CODE_MUST_BE_NULL = 'must-be-null';

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
        if ($value !== null) {
            return new ValidationResultBasic(
                false,
                static::CODE_MUST_BE_NULL
            );
        }

        return new ValidationResultBasic();
    }
}
