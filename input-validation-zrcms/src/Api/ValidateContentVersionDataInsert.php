<?php

namespace Zrcms\InputValidationZrcms\Api;

use Psr\Container\ContainerInterface;
use Zrcms\InputValidation\Api\BuildCode;
use Zrcms\InputValidation\Api\IsValidFieldResults;
use Zrcms\InputValidation\Api\Validate;
use Zrcms\InputValidation\Api\ValidateCompositeByStrategy;
use Zrcms\InputValidation\Api\ValidateFields;
use Zrcms\InputValidation\Api\ValidateFieldsHasOnlyRecognizedFields;
use Zrcms\InputValidation\Api\ValidateIsAssociativeArray;
use Zrcms\InputValidation\Api\ValidateIsNotEmpty;
use Zrcms\InputValidation\Api\ValidateIsNull;
use Zrcms\InputValidation\Api\ValidateIsString;
use Zrcms\InputValidation\Model\ValidationResultFields;
use Zrcms\InputValidation\Model\ValidationResultFieldsBasic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateContentVersionDataInsert implements ValidateFields
{
    const KEY_ID = 'id';
    const KEY_PROPERTIES = 'properties';
    const KEY_CREATED_BY_USER_ID = 'createdByUserId';
    const KEY_CREATED_REASON = 'createdReason';
    const KEY_CREATED_DATE = 'createdDate';

    const OPTION_VALIDATOR_OPTIONS = 'validator-options';
    const OPTION_VALIDATOR_OPTION_ID = 'id';
    const OPTION_VALIDATOR_OPTION_PROPERTIES = 'properties';
    const OPTION_VALIDATOR_OPTION_CREATED_BY_USER_ID = 'createdByUserId';
    const OPTION_VALIDATOR_OPTION_CREATED_REASON = 'createdReason';
    const OPTION_VALIDATOR_OPTION_CREATED_DATE = 'createdDate';

    const OPTION_INVALID_CODE = 'code-invalid';

    const DEFAULT_INVALID_CODE = 'invalid-content-version';

    protected $serviceContainer;
    protected $validateFieldsHasOnlyRecognizedFields;
    protected $validateProperties;
    protected $defaultInvalidCode;

    /**
     * @param ContainerInterface                                   $serviceContainer
     * @param ValidateFields|ValidateFieldsHasOnlyRecognizedFields $validateFieldsHasOnlyRecognizedFields
     * @param ValidateFields|ValidateProperties                    $validateProperties
     * @param string                                               $defaultInvalidCode
     */
    public function __construct(
        ContainerInterface $serviceContainer,
        ValidateFields $validateFieldsHasOnlyRecognizedFields,
        ValidateFields $validateProperties,
        string $defaultInvalidCode = self::DEFAULT_INVALID_CODE
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->validateFieldsHasOnlyRecognizedFields = $validateFieldsHasOnlyRecognizedFields;
        $this->validateProperties = $validateProperties;
        $this->defaultInvalidCode = $defaultInvalidCode;
    }

    /**
     * @param array $contentVersionData ['{name}' => '{value}']
     * @param array $options
     *
     * @return ValidationResultFields
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        array $contentVersionData,
        array $options = []
    ): ValidationResultFields {
        $validationsResult = $this->validateFieldsHasOnlyRecognizedFields->__invoke(
            $contentVersionData,
            [
                ValidateFieldsHasOnlyRecognizedFields::OPTION_FIELDS_ALLOWED => [
                    static::KEY_ID,
                    static::KEY_PROPERTIES,
                    static::KEY_CREATED_BY_USER_ID,
                    static::KEY_CREATED_REASON,
                    static::KEY_CREATED_DATE,
                ]
            ]
        );

        if (!$validationsResult->isValid()) {
            return $validationsResult;
        }

        $validatorOptions = Param::getArray(
            $options,
            static::OPTION_VALIDATOR_OPTIONS,
            []
        );

        $fieldResults = $this->getFieldValidationResults(
            $contentVersionData,
            $validatorOptions
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
     * @param array $validatorOptions
     * @param array $fieldResults
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function getFieldValidationResults(
        array $contentVersionData,
        array $validatorOptions = [],
        array $fieldResults = []
    ): array {
        $fieldResults = $this->validateId(
            $contentVersionData,
            $fieldResults,
            $validatorOptions
        );

        $fieldResults = $this->validateProperties(
            $contentVersionData,
            $fieldResults,
            $validatorOptions
        );

        $fieldResults = $this->validateCreatedByUserId(
            $contentVersionData,
            $fieldResults,
            $validatorOptions
        );

        $fieldResults = $this->validateCreatedReason(
            $contentVersionData,
            $fieldResults,
            $validatorOptions
        );

        $fieldResults = $this->validateCreatedDate(
            $contentVersionData,
            $fieldResults,
            $validatorOptions
        );

        return $fieldResults;
    }

    /**
     * @param array $contentVersionData
     * @param array $fieldResults
     * @param array $validatorOptions
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function validateId(
        array $contentVersionData,
        array $fieldResults,
        array $validatorOptions = []
    ): array {
        /** @var Validate $validator */
        $validator = $this->serviceContainer->get(ValidateIsNull::class);

        $fieldResults[static::KEY_ID] = $validator->__invoke(
            Param::get(
                $contentVersionData,
                static::KEY_ID
            ),
            Param::getArray(
                $validatorOptions,
                static::OPTION_VALIDATOR_OPTION_ID,
                []
            )
        );

        return $fieldResults;
    }

    /**
     * @param array $contentVersionData
     * @param array $fieldResults
     * @param array $validatorOptions
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function validateProperties(
        array $contentVersionData,
        array $fieldResults,
        array $validatorOptions = []
    ): array {
        /** @var Validate $validator */
        $validator = $this->serviceContainer->get(ValidateIsAssociativeArray::class);

        $validationResult = $validator->__invoke(
            Param::getArray(
                $contentVersionData,
                static::KEY_PROPERTIES
            ),
            Param::getArray(
                $validatorOptions,
                static::OPTION_VALIDATOR_OPTION_PROPERTIES,
                []
            )
        );

        if (!$validationResult->isValid()) {
            $fieldResults[static::KEY_PROPERTIES] = $validationResult;

            return $fieldResults;
        }

        $validationResult = $this->validateProperties->__invoke(
            Param::getArray(
                $contentVersionData,
                static::KEY_PROPERTIES
            ),
            Param::getArray(
                $validatorOptions,
                static::OPTION_VALIDATOR_OPTION_PROPERTIES,
                []
            )
        );

        if (!$validationResult->isValid()) {
            $fieldResults[static::KEY_PROPERTIES] = $validationResult;

            return $fieldResults;
        }

        return $fieldResults;
    }

    /**
     * @param array $contentVersionData
     * @param array $fieldResults
     * @param array $validatorOptions
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function validateCreatedByUserId(
        array $contentVersionData,
        array $fieldResults,
        array $validatorOptions = []
    ): array {
        /** @var Validate $validator */
        $validator = $this->serviceContainer->get(ValidateIsNull::class);

        $fieldResults[static::KEY_CREATED_BY_USER_ID] = $validator->__invoke(
            Param::get(
                $contentVersionData,
                static::KEY_CREATED_BY_USER_ID
            ),
            Param::getArray(
                $validatorOptions,
                static::OPTION_VALIDATOR_OPTION_CREATED_BY_USER_ID,
                []
            )
        );

        return $fieldResults;
    }

    /**
     * @param array $contentVersionData
     * @param array $fieldResults
     * @param array $validatorOptions
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function validateCreatedReason(
        array $contentVersionData,
        array $fieldResults,
        array $validatorOptions = []
    ): array {
        /** @var Validate $validator */
        $validator = $this->serviceContainer->get(ValidateCompositeByStrategy::class);

        $validatorOptions = Param::getArray(
            $validatorOptions,
            static::OPTION_VALIDATOR_OPTION_CREATED_REASON,
            []
        );

        $validatorOptions['validators'] = [
            [
                'validator' => ValidateIsNotEmpty::class,
            ],
            [
                'validator' => ValidateIsString::class,
            ],
        ];

        $fieldResults[static::KEY_CREATED_REASON] = $validator->__invoke(
            Param::getString(
                $contentVersionData,
                static::KEY_CREATED_REASON
            ),
            $validatorOptions
        );

        return $fieldResults;
    }

    /**
     * @param array $contentVersionData
     * @param array $fieldResults
     * @param array $validatorOptions
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function validateCreatedDate(
        array $contentVersionData,
        array $fieldResults,
        array $validatorOptions = []
    ): array {
        /** @var Validate $validator */
        $validator = $this->serviceContainer->get(ValidateIsNull::class);

        $fieldResults[static::KEY_CREATED_DATE] = $validator->__invoke(
            Param::get(
                $contentVersionData,
                static::KEY_CREATED_DATE
            ),
            Param::getArray(
                $validatorOptions,
                static::OPTION_VALIDATOR_OPTION_CREATED_DATE,
                []
            )
        );

        return $fieldResults;
    }
}
