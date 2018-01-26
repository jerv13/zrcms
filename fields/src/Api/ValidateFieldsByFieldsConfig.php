<?php

namespace Zrcms\Fields\Api;

use Zrcms\Fields\Model\FieldConfig;
use Zrcms\Fields\Model\FieldType;
use Zrcms\InputValidation\Api\BuildCode;
use Zrcms\InputValidation\Api\IsValidFieldResults;
use Zrcms\InputValidation\Api\ValidateFields;
use Zrcms\InputValidation\Api\ValidateFieldsHasOnlyRecognizedFields;
use Zrcms\InputValidation\Model\ValidationResultFields;
use Zrcms\InputValidation\Model\ValidationResultFieldsBasic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateFieldsByFieldsConfig implements ValidateFields
{
    const OPTION_FIELDS_CONFIG = 'fields-config';
    const OPTION_FIELDS_ALLOWED = ValidateFieldsHasOnlyRecognizedFields::OPTION_FIELDS_ALLOWED;

    const DEFAULT_INVALID_CODE = 'invalid-fields-for-fields-config';

    protected $validateFieldsHasOnlyRecognizedFields;
    protected $validateByFieldTypeRequired;
    protected $validateByFieldType;
    protected $validateByFieldConfigValidator;
    protected $defaultInvalidCode;

    /**
     * @param ValidateFields                 $validateFieldsHasOnlyRecognizedFields
     * @param ValidateByFieldTypeRequired    $validateByFieldTypeRequired
     * @param ValidateByFieldType            $validateByFieldType
     * @param ValidateByFieldConfigValidator $validateByFieldConfigValidator
     * @param string                         $defaultInvalidCode
     */
    public function __construct(
        ValidateFields $validateFieldsHasOnlyRecognizedFields,
        ValidateByFieldTypeRequired $validateByFieldTypeRequired,
        ValidateByFieldType $validateByFieldType,
        ValidateByFieldConfigValidator $validateByFieldConfigValidator,
        string $defaultInvalidCode = self::DEFAULT_INVALID_CODE
    ) {
        $this->validateFieldsHasOnlyRecognizedFields = $validateFieldsHasOnlyRecognizedFields;
        $this->validateByFieldTypeRequired = $validateByFieldTypeRequired;
        $this->validateByFieldType = $validateByFieldType;
        $this->validateByFieldConfigValidator = $validateByFieldConfigValidator;
        $this->defaultInvalidCode = $defaultInvalidCode;
    }

    /**
     * @param array $fields ['{name}' => '{value}']
     * @param array $options
     *
     * @return ValidationResultFields
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     * @throws \Zrcms\Param\Exception\ParamException
     */
    public function __invoke(
        array $fields,
        array $options = []
    ): ValidationResultFields {
        $fieldsConfig = Param::getRequired(
            $options,
            static::OPTION_FIELDS_CONFIG
        );

        $fieldsConfigByName = BuildFieldsConfigNameIndex::invoke($fieldsConfig);

        // Only recognized fields
        $validationResult = $this->validateFieldsHasOnlyRecognizedFields->__invoke(
            $fields,
            [
                static::OPTION_FIELDS_ALLOWED => $this->buildRecognizedFields($fieldsConfigByName)
            ]
        );

        if (!$validationResult->isValid()) {
            return $validationResult;
        }

        $fieldResults = $this->getFieldValidationResults(
            $fields,
            $fieldsConfigByName
        );

        $valid = IsValidFieldResults::invoke(
            $fieldResults,
            $options
        );

        $code = BuildCode::invoke(
            $valid,
            $options,
            $this->defaultInvalidCode
        );

        return new ValidationResultFieldsBasic(
            $valid,
            $code,
            [],
            $fieldResults
        );
    }

    /**
     * @param array $fieldsConfigByName
     *
     * @return array
     */
    protected function buildRecognizedFields(
        array $fieldsConfigByName
    ): array {
        return array_keys($fieldsConfigByName);
    }

    /**
     * @param array $fields
     * @param array $fieldsConfigByName
     * @param array $fieldResults
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     * @throws \Zrcms\Param\Exception\ParamException
     */
    protected function getFieldValidationResults(
        array $fields,
        array $fieldsConfigByName = [],
        array $fieldResults = []
    ): array {
        foreach ($fields as $fieldName => $value) {
            $fieldConfig = Param::getRequired(
                $fieldsConfigByName,
                $fieldName
            );

            $required = Param::getBool(
                $fieldConfig,
                FieldConfig::REQUIRED,
                false
            );

            $type = Param::getString(
                $fieldConfig,
                FieldConfig::REQUIRED,
                FieldType::DEFAULT_TYPE
            );

            $requiredValidationResult = null;

            if ($required) {
                $requiredValidationResult = $this->validateByFieldTypeRequired->__invoke(
                    $value,
                    [ValidateByFieldTypeRequired::OPTION_FIELD_TYPE => $type]
                );
            }

            if ($required && !$requiredValidationResult->isValid()) {
                $fieldResults[$fieldName] = $requiredValidationResult;
                continue;
            }

            $validationResult = $this->validateByFieldType->__invoke(
                $value,
                [ValidateByFieldType::OPTION_FIELD_TYPE => $type]
            );

            if (!$validationResult->isValid()) {
                $fieldResults[$fieldName] = $validationResult;
                continue;
            }

            $options = Param::getArray(
                $fieldConfig,
                FieldConfig::OPTIONS,
                []
            );

            $fieldResults[$fieldName] = $this->validateByFieldConfigValidator->__invoke(
                $value,
                [ValidateByFieldConfigValidator::OPTION_FIELD_CONFIG_OPTIONS => $options]
            );
        }

        return $fieldResults;
    }
}
