<?php

namespace Zrcms\InputValidation\Model;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidationResultNoValidation extends ValidationResultBasic implements ValidationResult
{
    const CODE = 'no-validation';

    public function __construct(
        array $details = []
    ) {
        parent::__construct(
            false,
            static::CODE,
            $details
        );
    }
}
