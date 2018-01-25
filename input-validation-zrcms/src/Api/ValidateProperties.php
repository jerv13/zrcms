<?php

namespace Zrcms\InputValidationZrcms\Api;

use Psr\Container\ContainerInterface;
use Zrcms\InputValidation\Api\ValidateFields;
use Zrcms\InputValidation\Api\ValidateFieldsHasOnlyRecognizedFields;
use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\InputValidation\Model\ValidationResultFields;
use Zrcms\InputValidation\Model\ValidationResultFieldsBasic;
use Zrcms\Param\Param;

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
        $valid = $this->isValid($fieldResults, $options);
        $code = $this->getCode($valid, $options);

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

    /**
     * @param bool  $valid
     * @param array $options
     *
     * @return string
     */
    protected function getCode(
        bool $valid,
        array $options = []
    ): string {
        if ($valid) {
            return '';
        };

        return Param::getString(
            $options,
            static::OPTION_INVALID_CODE,
            $this->defaultInvalidCode
        );
    }

    /**
     * @param array $fieldResults
     * @param array $options
     *
     * @return bool
     */
    protected function isValid(
        array $fieldResults,
        array $options = []
    ): bool {
        /** @var ValidationResult $validationResult */
        foreach ($fieldResults as $validationResult) {
            if (!$validationResult->isValid()) {
                return false;
            }
        }

        return true;
    }
}
