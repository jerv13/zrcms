<?php

namespace Zrcms\InputValidationZrcms\Api;

use Psr\Container\ContainerInterface;
use Zrcms\InputValidation\Api\BuildCode;
use Zrcms\InputValidation\Api\IsValidFieldResults;
use Zrcms\InputValidation\Api\Validate;
use Zrcms\InputValidation\Api\ValidateCompositeByStrategy;
use Zrcms\InputValidation\Api\ValidateFields;
use Zrcms\InputValidation\Api\ValidateFieldsHasOnlyRecognizedFields;
use Zrcms\InputValidation\Api\ValidateIsAnyValue;
use Zrcms\InputValidation\Api\ValidateIsBoolean;
use Zrcms\InputValidation\Api\ValidateIsNotEmpty;
use Zrcms\InputValidation\Api\ValidateIsNull;
use Zrcms\InputValidation\Api\ValidateIsRealValue;
use Zrcms\InputValidation\Api\ValidateIsString;
use Zrcms\InputValidation\Model\ValidationResultFields;
use Zrcms\InputValidation\Model\ValidationResultFieldsBasic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateCmsResourceDataUpsert implements ValidateFields
{
    const KEY_ID = 'id';
    const KEY_PUBLISHED = 'published';
    const KEY_CONTENT_VERSION = 'contentVersion';
    const KEY_CREATED_BY_USER_ID = 'createdByUserId';
    const KEY_CREATED_REASON = 'createdReason';
    const KEY_CREATED_DATE = 'createdDate';

    const OPTION_VALIDATOR_OPTIONS = 'validator-options';
    const OPTION_VALIDATOR_OPTION_ID = 'id';
    const OPTION_VALIDATOR_OPTION_PUBLISHED = 'published';
    const OPTION_VALIDATOR_OPTION_CONTENT_VERSION = 'contentVersion';
    const OPTION_VALIDATOR_OPTION_CREATED_BY_USER_ID = 'createdByUserId';
    const OPTION_VALIDATOR_OPTION_CREATED_REASON = 'createdReason';
    const OPTION_VALIDATOR_OPTION_CREATED_DATE = 'createdDate';

    const OPTION_INVALID_CODE = BuildCode::OPTION_INVALID_CODE;

    const DEFAULT_INVALID_CODE = 'invalid-cms-resource';

    protected $serviceContainer;
    protected $validateFieldsHasOnlyRecognizedFields;
    protected $validateIsRealValue;
    protected $validateContentVersion;
    protected $defaultInvalidCode;

    /**
     * @param ContainerInterface               $serviceContainer
     * @param ValidateFields                   $validateFieldsHasOnlyRecognizedFields
     * @param ValidateIsRealValue              $validateIsRealValue
     * @param ValidateContentVersionDataInsert $validateContentVersion
     * @param string                           $defaultInvalidCode
     */
    public function __construct(
        ContainerInterface $serviceContainer,
        ValidateFields $validateFieldsHasOnlyRecognizedFields,
        ValidateIsRealValue $validateIsRealValue,
        ValidateContentVersionDataInsert $validateContentVersionDataInsert,
        string $defaultInvalidCode = self::DEFAULT_INVALID_CODE
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->validateFieldsHasOnlyRecognizedFields = $validateFieldsHasOnlyRecognizedFields;
        $this->validateIsRealValue = $validateIsRealValue;
        $this->validateContentVersionDataInsert = $validateContentVersionDataInsert;
        $this->defaultInvalidCode = $defaultInvalidCode;
    }

    /**
     * @param array $cmsResourceData ['{name}' => '{value}']
     * @param array $options
     *
     * @return ValidationResultFields
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        array $cmsResourceData,
        array $options = []
    ): ValidationResultFields {
        $validationsResult = $this->validateFieldsHasOnlyRecognizedFields->__invoke(
            $cmsResourceData,
            [
                ValidateFieldsHasOnlyRecognizedFields::OPTION_FIELDS_ALLOWED => [
                    static::KEY_ID,
                    static::KEY_PUBLISHED,
                    static::KEY_CONTENT_VERSION,
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
            $cmsResourceData,
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
     * @param array $cmsResourceData
     * @param array $validatorOptions
     * @param array $fieldResults
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function getFieldValidationResults(
        array $cmsResourceData,
        array $validatorOptions = [],
        array $fieldResults = []
    ): array {
        $fieldResults = $this->validateId(
            $cmsResourceData,
            $fieldResults,
            $validatorOptions
        );

        $fieldResults = $this->validatePublished(
            $cmsResourceData,
            $fieldResults,
            $validatorOptions
        );

        $fieldResults = $this->validateContentVersion(
            $cmsResourceData,
            $fieldResults,
            $validatorOptions
        );

        $fieldResults = $this->validateCreatedByUserId(
            $cmsResourceData,
            $fieldResults,
            $validatorOptions
        );

        $fieldResults = $this->validateCreatedReason(
            $cmsResourceData,
            $fieldResults,
            $validatorOptions
        );

        $fieldResults = $this->validateCreatedDate(
            $cmsResourceData,
            $fieldResults,
            $validatorOptions
        );

        return $fieldResults;
    }

    /**
     * @param array $cmsResourceData
     * @param array $fieldResults
     * @param array $validatorOptions
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function validateId(
        array $cmsResourceData,
        array $fieldResults,
        array $validatorOptions = []
    ): array {
        /** @var Validate $validator */
        $validator = $this->serviceContainer->get(ValidateIsAnyValue::class);

        $fieldResults[static::KEY_ID] = $validator->__invoke(
            Param::get(
                $cmsResourceData,
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
     * @param array $cmsResourceData
     * @param array $fieldResults
     * @param array $validatorOptions
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function validatePublished(
        array $cmsResourceData,
        array $fieldResults,
        array $validatorOptions = []
    ): array {
        /** @var Validate $validator */
        $validator = $this->serviceContainer->get(ValidateIsBoolean::class);

        $fieldResults[static::KEY_PUBLISHED] = $validator->__invoke(
            Param::getBool(
                $cmsResourceData,
                static::KEY_PUBLISHED
            ),
            Param::getArray(
                $validatorOptions,
                static::OPTION_VALIDATOR_OPTION_PUBLISHED,
                []
            )
        );

        return $fieldResults;
    }

    /**
     * @param array $cmsResourceData
     * @param array $fieldResults
     * @param array $validatorOptions
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function validateContentVersion(
        array $cmsResourceData,
        array $fieldResults,
        array $validatorOptions = []
    ): array {
        $contentVersion = Param::getArray(
            $cmsResourceData,
            static::KEY_CONTENT_VERSION,
            []
        );

        $contentVersionId = Param::getString(
            $contentVersion,
            'id'
        );

        // Case 1 for Upsert - New Content Version (insert)
        if (empty($contentVersionId)) {
            $fieldResults[static::KEY_CONTENT_VERSION] = $this->validateContentVersionDataInsert->__invoke(
                $contentVersion,
                Param::getArray(
                    $validatorOptions,
                    static::OPTION_VALIDATOR_OPTION_CONTENT_VERSION,
                    []
                )
            );

            return $fieldResults;
        }

        // Case 2 for Upsert - Existing Content Version (change link)
        $this->validateIsRealValue->__invoke(
            $contentVersionId
        );

        // @todo It might be good to check if the ContentVersion for the ID exists, but it will be extra trip to DB
        // @todo Also will require us to know what type on implementation we are dealing with

        return $fieldResults;
    }

    /**
     * @param array $cmsResourceData
     * @param array $fieldResults
     * @param array $validatorOptions
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function validateCreatedByUserId(
        array $cmsResourceData,
        array $fieldResults,
        array $validatorOptions = []
    ): array {
        /** @var Validate $validator */
        $validator = $this->serviceContainer->get(ValidateIsNull::class);

        $fieldResults[static::KEY_CREATED_BY_USER_ID] = $validator->__invoke(
            Param::get(
                $cmsResourceData,
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
     * @param array $cmsResourceData
     * @param array $fieldResults
     * @param array $validatorOptions
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function validateCreatedReason(
        array $cmsResourceData,
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
                $cmsResourceData,
                static::KEY_CREATED_REASON
            ),
            $validatorOptions
        );

        return $fieldResults;
    }

    /**
     * @param array $cmsResourceData
     * @param array $fieldResults
     * @param array $validatorOptions
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function validateCreatedDate(
        array $cmsResourceData,
        array $fieldResults,
        array $validatorOptions = []
    ): array {
        /** @var Validate $validator */
        $validator = $this->serviceContainer->get(ValidateIsNull::class);

        $fieldResults[static::KEY_CREATED_DATE] = $validator->__invoke(
            Param::get(
                $cmsResourceData,
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
