<?php

namespace Zrcms\InputValidation\Model;

use Zrcms\InputValidation\Exception\FieldDoesNotExist;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidationResultFieldsBasic extends ValidationResultBasic implements ValidationResultFields
{
    protected $fieldResults = [];

    /**
     * @param bool   $valid
     * @param string $code
     * @param array  $details
     * @param array  $fieldResults
     */
    public function __construct(
        bool $valid = true,
        string $code = '',
        array $details = [],
        array $fieldResults = []
    ) {
        parent::__construct(
            $valid,
            $code,
            $details
        );
    }

    /**
     * @param string $fieldName
     *
     * @return ValidationResult
     * @throws FieldDoesNotExist
     */
    public function getFieldResult(string $fieldName): ValidationResult
    {
        if (!array_key_exists($fieldName, $this->fieldResults)) {
            throw new FieldDoesNotExist(
                'Field does not exist: ' . $fieldName
            );
        }

        return $this->fieldResults[$fieldName];
    }

    /**
     * @param array $fieldResults
     *
     * @return void
     */
    protected function setFieldResults(array $fieldResults)
    {
        foreach ($fieldResults as $fieldName => $validationResult) {
            $this->setFieldResult($fieldName, $validationResult);
        }
    }

    /**
     * @param string           $fieldName
     * @param ValidationResult $validationResult
     *
     * @return void
     */
    protected function setFieldResult(string $fieldName, ValidationResult $validationResult)
    {
        $this->fieldResults[$fieldName] = $validationResult;
    }
}
