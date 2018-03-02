<?php

namespace Zrcms\ValidationRatZrcms\Api\Validator;

use Reliv\ValidationRat\Api\Validator\Validate;
use Reliv\ValidationRat\Model\ValidationResult;
use Reliv\ValidationRat\Model\ValidationResultBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateContentVersionId implements Validate
{
    const CODE_MUST_BE_NULL_OR_STRING = 'content-version-id-must-be-null-or-string';

    protected $validateIsNull;
    protected $validateIsString;

    /**
     * @param Validate $validateIsNull
     * @param Validate $validateIsString
     */
    public function __construct(
        Validate $validateIsNull,
        Validate $validateIsString
    ) {
        $this->validateIsNull = $validateIsNull;
        $this->validateIsString = $validateIsString;
    }

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
        $isStringResult = $this->validateIsString->__invoke(
            $value,
            $options
        );

        $isNullResult = $this->validateIsNull->__invoke(
            $value,
            $options
        );

        /**
         * MUST be a string or null
         */
        if ($isStringResult->isValid() || $isNullResult->isValid()) {
            return new ValidationResultBasic();
        }

        return new ValidationResultBasic(
            false,
            static::CODE_MUST_BE_NULL_OR_STRING
        );
    }
}
