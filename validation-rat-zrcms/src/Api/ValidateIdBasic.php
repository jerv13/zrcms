<?php

namespace Zrcms\ValidationRatZrcms\Api;

use Reliv\ValidationRat\Model\ValidationResult;
use Reliv\ValidationRat\Model\ValidationResultBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateIdBasic implements ValidateId
{
    const CODE_EMPTY_ID = 'id-must-not-be-empty';
    const CODE_MUST_BE_STRING = 'id-must-be-string';

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
                static::CODE_MUST_BE_STRING
            );
        }

        // @todo More security checks

        return new ValidationResultBasic();
    }
}
