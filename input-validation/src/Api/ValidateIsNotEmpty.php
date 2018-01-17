<?php

namespace Zrcms\InputValidation\Api;

use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\InputValidation\Model\ValidationResultBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateIsNotEmpty implements Validate
{
    const CODE_MUST_NOT_BE_EMPTY = 'must-not-be-empty';

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
        if (empty($value)) {
            return new ValidationResultBasic(
                false,
                static::CODE_MUST_NOT_BE_EMPTY
            );
        }

        return new ValidationResultBasic();
    }
}
