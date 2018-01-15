<?php

namespace Zrcms\InputValidation\Model;

use Zrcms\InputValidation\Exception\FieldDoesNotExist;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ValidationResultFields extends ValidationResult
{
    /**
     * @param string $fieldName
     *
     * @return ValidationResult
     * @throws FieldDoesNotExist
     */
    public function getFieldResult(string $fieldName): ValidationResult;
}
