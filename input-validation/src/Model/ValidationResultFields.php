<?php

namespace Zrcms\InputValidation\Model;

use Zrcms\InputValidation\Exception\FieldDoesNotExist;

/**
 * @author James Jervis - https://github.com/jerv13
 */
interface ValidationResultFields extends ValidationResult
{
    /**
     * @return ValidationResult[]
     */
    public function getFieldResults(): array;

    /**
     * @param string $fieldName
     *
     * @return ValidationResult
     * @throws FieldDoesNotExist
     */
    public function findFieldResult(string $fieldName): ValidationResult;
}
