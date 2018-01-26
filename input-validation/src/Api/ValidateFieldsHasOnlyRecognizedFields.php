<?php

namespace Zrcms\InputValidation\Api;

use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\InputValidation\Model\ValidationResultBasic;
use Zrcms\InputValidation\Model\ValidationResultFields;
use Zrcms\InputValidation\Model\ValidationResultFieldsBasic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateFieldsHasOnlyRecognizedFields implements ValidateFields
{
    const CODE_UNRECOGNIZED_FIELD = 'unrecognized-field';

    const OPTION_FIELDS_ALLOWED = 'fields-allowed';

    /**
     * @param array $fields ['{name}' => '{value}']
     * @param array $options
     *
     * @return ValidationResultFields
     */
    public function __invoke(
        array $fields,
        array $options = []
    ): ValidationResultFields {
        $allowedFields = Param::getArray(
            $options,
            static::OPTION_FIELDS_ALLOWED,
            []
        );

        $fieldResults = $this->getFieldValidationResults(
            $fields,
            $allowedFields
        );

        $valid = IsValidFieldResults::invoke(
            $fieldResults,
            $options
        );

        $code = BuildCode::invoke(
            $valid,
            $options,
            static::CODE_UNRECOGNIZED_FIELD
        );

        if (!$valid) {
            $details['unrecognized-fields'] = $this->buildUnrecognizedFields(
                $fieldResults
            );
        }

        return new ValidationResultFieldsBasic(
            $valid,
            $code,
            $details,
            $fieldResults
        );
    }

    /**
     * @param array $fields
     * @param array $allowedFields
     * @param array $fieldResults
     *
     * @return array
     */
    protected function getFieldValidationResults(
        array $fields,
        array $allowedFields = [],
        array $fieldResults = []
    ): array {
        foreach ($fields as $fieldName => $value) {
            if (!in_array($fieldName, $allowedFields)) {
                $fieldResults[$fieldName] = new ValidationResultBasic(
                    false,
                    self::CODE_UNRECOGNIZED_FIELD,
                    ['message' => 'Unrecognized field received: (' . $fieldName . ')']
                );
            }
        }

        return $fieldResults;
    }

    /**
     * @param array $fieldResults
     * @param array $options
     * @param array $unrecognizedFields
     *
     * @return array
     */
    protected function buildUnrecognizedFields(
        array $fieldResults,
        array $options = [],
        array $unrecognizedFields = []
    ): array {
        /** @var ValidationResult $validationResult */
        foreach ($fieldResults as $fieldName => $validationResult) {
            if (!$validationResult->isValid()) {
                $unrecognizedFields[] = $fieldName;
            }
        }

        return $unrecognizedFields;
    }
}
