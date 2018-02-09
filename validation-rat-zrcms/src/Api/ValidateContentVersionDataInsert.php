<?php

namespace Zrcms\ValidationRatZrcms\Api;

use Psr\Container\ContainerInterface;
use Reliv\ValidationRat\Api\BuildCode;
use Reliv\ValidationRat\Api\IsValidFieldResults;
use Reliv\ValidationRat\Api\Validator\Validate;
use Reliv\ValidationRat\Api\Validator\ValidateCompositeByStrategy;
use Reliv\ValidationRat\Api\FieldValidator\ValidateFields;
use Reliv\ValidationRat\Api\FieldValidator\ValidateFieldsHasOnlyRecognizedFields;
use Reliv\ValidationRat\Api\Validator\ValidateIsAssociativeArray;
use Reliv\ValidationRat\Api\Validator\ValidateIsNotEmpty;
use Reliv\ValidationRat\Api\Validator\ValidateIsNull;
use Reliv\ValidationRat\Api\Validator\ValidateIsString;
use Reliv\ValidationRat\Model\ValidationResultFields;
use Reliv\ValidationRat\Model\ValidationResultFieldsBasic;
use Reliv\ArrayProperties\Property;

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

        $validatorOptions = Property::getArray(
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
            Property::get(
                $contentVersionData,
                static::KEY_ID
            ),
            Property::getArray(
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
            Property::getArray(
                $contentVersionData,
                static::KEY_PROPERTIES
            ),
            Property::getArray(
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
            Property::getArray(
                $contentVersionData,
                static::KEY_PROPERTIES
            ),
            Property::getArray(
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
            Property::get(
                $contentVersionData,
                static::KEY_CREATED_BY_USER_ID
            ),
            Property::getArray(
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

        $validatorOptions = Property::getArray(
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
            Property::getString(
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
            Property::get(
                $contentVersionData,
                static::KEY_CREATED_DATE
            ),
            Property::getArray(
                $validatorOptions,
                static::OPTION_VALIDATOR_OPTION_CREATED_DATE,
                []
            )
        );

        return $fieldResults;
    }
}
