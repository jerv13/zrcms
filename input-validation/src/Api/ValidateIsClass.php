<?php

namespace Zrcms\InputValidation\Api;

use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\InputValidation\Model\ValidationResultBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateIsClass implements Validate
{
    const CODE_MUST_BE_CLASS_NAME = 'must-be-class-name';
    const CODE_MUST_BE_CLASS = 'must-be-class';
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
        if (!is_string($value)) {
            return new ValidationResultBasic(
                false,
                static::CODE_MUST_BE_CLASS_NAME
            );
        }

        if (!class_exists($value)) {
            return new ValidationResultBasic(
                false,
                static::CODE_MUST_BE_CLASS
            );
        }

        return new ValidationResultBasic();
    }
}
