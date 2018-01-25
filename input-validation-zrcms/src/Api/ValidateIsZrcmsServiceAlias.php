<?php

namespace Zrcms\InputValidationZrcms\Api;

use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\InputValidation\Model\ValidationResultBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateIsZrcmsServiceAlias implements ValidateId
{
    const CODE_MUST_BE_STRING = 'zrcms-service-alias-must-be-string';
    const CODE_MUST_BE_ZRCMS_SERVICE_ALIAS = 'must-be-zrcms-service-alias';

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
        if (!is_string($id)) {
            return new ValidationResultBasic(
                false,
                static::CODE_MUST_BE_STRING
            );
        }

        return new ValidationResultBasic();
    }
}
