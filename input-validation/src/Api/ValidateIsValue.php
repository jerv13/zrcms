<?php

namespace Zrcms\InputValidation\Api;

use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\InputValidation\Model\ValidationResultBasic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateIsValue implements Validate
{
    const OPTION_REQUIRED_VALUE = 'required-value';

    const CODE_MUST_BE_REQUIRED_VALUE = 'must-be-required-value';

    /**
     * @param mixed $value
     * @param array $options
     *
     * @return ValidationResult
     * @throws \Throwable
     * @throws \Zrcms\Param\Exception\ParamException
     */
    public function __invoke(
        $value,
        array $options = []
    ): ValidationResult {
        $requiredValue = Param::getRequired(
            $options,
            static::OPTION_REQUIRED_VALUE
        );

        if ($value !== $requiredValue) {
            return new ValidationResultBasic(
                false,
                static::CODE_MUST_BE_REQUIRED_VALUE,
                [
                    static::OPTION_REQUIRED_VALUE => $requiredValue,
                ]
            );
        }

        return new ValidationResultBasic();
    }
}
