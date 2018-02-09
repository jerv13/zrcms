<?php

namespace Zrcms\ValidationRatZrcms\Api;

use Psr\Container\ContainerInterface;
use Reliv\ValidationRat\Api\BuildCode;
use Reliv\ValidationRat\Api\IsValidFieldResults;
use Reliv\ValidationRat\Api\FieldValidator\ValidateFields;
use Reliv\ValidationRat\Api\FieldValidator\ValidateFieldsHasOnlyRecognizedFields;
use Reliv\ValidationRat\Model\ValidationResultFields;
use Reliv\ValidationRat\Model\ValidationResultFieldsBasic;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateProperties implements ValidateFields
{
    const OPTION_INVALID_CODE = 'code-invalid';
    const OPTION_FIELDS_ALLOWED = ValidateFieldsHasOnlyRecognizedFields::OPTION_FIELDS_ALLOWED;

    const DEFAULT_INVALID_CODE = 'invalid-properties';

    protected $serviceContainer;
    protected $validateFieldsHasOnlyRecognizedFields;
    protected $defaultInvalidCode;

    /**
     * @param ContainerInterface                                   $serviceContainer
     * @param ValidateFields|ValidateFieldsHasOnlyRecognizedFields $validateFieldsHasOnlyRecognizedFields
     * @param string                                               $defaultInvalidCode
     */
    public function __construct(
        ContainerInterface $serviceContainer,
        ValidateFields $validateFieldsHasOnlyRecognizedFields,
        string $defaultInvalidCode = self::DEFAULT_INVALID_CODE
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->validateFieldsHasOnlyRecognizedFields = $validateFieldsHasOnlyRecognizedFields;
        $this->defaultInvalidCode = $defaultInvalidCode;
    }

    /**
     * @param array $properties
     * @param array $options
     *
     * @return ValidationResultFields
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        array $properties,
        array $options = []
    ): ValidationResultFields {
        $validationsResult = $this->validateFieldsHasOnlyRecognizedFields->__invoke(
            $properties,
            $options
        );

        if (!$validationsResult->isValid()) {
            return $validationsResult;
        }

        $fieldResults = $this->getFieldValidationResults(
            $properties,
            $options
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
     * @param array $contentVersionData
     * @param array $options
     * @param array $fieldResults
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function getFieldValidationResults(
        array $contentVersionData,
        array $options = [],
        array $fieldResults = []
    ): array {
        // @todo Over-ride with validations for use case
        return $fieldResults;
    }
}
