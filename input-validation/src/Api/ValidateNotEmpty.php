<?php

namespace Zrcms\InputValidation\Api;

use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\InputValidation\Model\ValidationResultBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateNotEmpty implements Validate
{
    const CODE_EMPTY_VALUE = 'empty-value';

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
                static::CODE_EMPTY_VALUE
            );
        }

        return new ValidationResultBasic();
    }
}
