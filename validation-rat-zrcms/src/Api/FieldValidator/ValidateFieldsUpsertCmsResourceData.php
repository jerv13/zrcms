<?php

namespace Zrcms\ValidationRatZrcms\Api\FieldValidator;

use Reliv\ArrayProperties\Property;
use Reliv\ValidationRat\Api\AddValidationResult;
use Reliv\ValidationRat\Api\BuildCode;
use Reliv\ValidationRat\Api\FieldValidator\ValidateFields;
use Reliv\ValidationRat\Api\FieldValidator\ValidateFieldsHasOnlyRecognizedFields;
use Reliv\ValidationRat\Api\IsValidFieldResults;
use Reliv\ValidationRat\Api\MergeValidationResultsFields;
use Reliv\ValidationRat\Api\Validator\ValidateCompositeByStrategy;
use Reliv\ValidationRat\Api\Validator\ValidateIsBoolean;
use Reliv\ValidationRat\Api\Validator\ValidateIsNotEmpty;
use Reliv\ValidationRat\Api\Validator\ValidateIsNull;
use Reliv\ValidationRat\Api\Validator\ValidateIsRealValue;
use Reliv\ValidationRat\Api\Validator\ValidateIsString;
use Reliv\ValidationRat\Model\ValidationResultFields;
use Reliv\ValidationRat\Model\ValidationResultFieldsBasic;
use Zrcms\ValidationRatZrcms\Api\Validator\ValidateCmsResourceId;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateFieldsUpsertCmsResourceData implements ValidateFields
{
    const KEY_ID = 'id';
    const KEY_PUBLISHED = 'published';
    const KEY_CONTENT_VERSION = 'contentVersion';
    const KEY_CREATED_BY_USER_ID = 'createdByUserId';
    const KEY_CREATED_REASON = 'createdReason';
    const KEY_CREATED_DATE = 'createdDate';

    const OPTION_INVALID_CODE = BuildCode::OPTION_INVALID_CODE;

    const OPTION_VALIDATOR_ID = 'validator-id';
    const OPTION_VALIDATOR_OPTIONS_ID = 'validator-options-id';

    const OPTION_VALIDATOR_PUBLISHED = 'validator-published';
    const OPTION_VALIDATOR_OPTIONS_PUBLISHED = 'validator-options-published';

    const OPTION_VALIDATOR_CREATED_BY_USER_ID = 'validator-created-by-user-id';
    const OPTION_VALIDATOR_OPTIONS_CREATED_BY_USER_ID = 'validator-options-created-by-user-id';

    const OPTION_VALIDATOR_CREATED_REASON = 'validator-created-reason';
    const OPTION_VALIDATOR_OPTIONS_CREATED_REASON = 'validator-options-created-reason';

    const OPTION_VALIDATOR_CREATED_DATE = 'validator-created-date';
    const OPTION_VALIDATOR_OPTIONS_CREATED_DATE = 'validator-options-created-date';

    const OPTION_FIELDS_VALIDATOR_INSERT_CONTENT_VERSION = 'fields-validator-insert-content-version';
    const OPTION_FIELDS_VALIDATOR_OPTIONS_INSERT_CONTENT_VERSION = 'fields-validator-options-insert-content-version';

    const OPTION_FIELDS_VALIDATOR_INSERT_CONTENT_VERSION_PROPERTIES
        = 'fields-validator-insert-content-version-properties';
    const OPTION_FIELDS_VALIDATOR_OPTIONS_INSERT_CONTENT_VERSION_PROPERTIES
        = 'fields-validator-options-insert-content-version-properties';

    const DEFAULT_INVALID_CODE = 'invalid-cms-resource';

    const DEFAULT_VALIDATOR_ID = ValidateCmsResourceId::class;
    const DEFAULT_VALIDATOR_OPTIONS_ID = [];

    const DEFAULT_VALIDATOR_PUBLISHED = ValidateIsBoolean::class;
    const DEFAULT_VALIDATOR_OPTIONS_PUBLISHED = [];

    const DEFAULT_VALIDATOR_CREATED_BY_USER_ID = ValidateIsNull::class;
    const DEFAULT_VALIDATOR_OPTIONS_CREATED_BY_USER_ID = [];

    const DEFAULT_VALIDATOR_CREATED_REASON = ValidateCompositeByStrategy::class;
    const DEFAULT_VALIDATOR_OPTIONS_CREATED_REASON
        = [
            ValidateCompositeByStrategy::OPTION_VALIDATORS => [
                'not-empty' => [
                    'validator' => ValidateIsNotEmpty::class,
                ],
                'is-string' => [
                    'validator' => ValidateIsString::class,
                ],
            ]
        ];

    const DEFAULT_VALIDATOR_CREATED_DATE = ValidateIsNull::class;
    const DEFAULT_VALIDATOR_OPTIONS_CREATED_DATE = [];

    const DEFAULT_FIELDS_VALIDATOR_INSERT_CONTENT_VERSION = ValidateFieldsInsertContentVersionData::class;
    const DEFAULT_FIELDS_VALIDATOR_OPTIONS_INSERT_CONTENT_VERSION = [];

    const DEFAULT_FIELDS_VALIDATOR_INSERT_CONTENT_VERSION_PROPERTIES = ValidateFieldsContentVersionProperties::class;
    const DEFAULT_FIELDS_VALIDATOR_OPTIONS_INSERT_CONTENT_VERSION_PROPERTIES = [];

    protected $buildFieldValidationResults;
    protected $validateFieldsHasOnlyRecognizedFields;
    protected $validateIsRealValue;
    protected $defaultInvalidCode;

    protected $defaultValidatorId;
    protected $defaultValidatorPublished;
    protected $defaultValidatorCreatedByUserId;
    protected $defaultValidatorCreatedReason;
    protected $defaultValidatorCreatedDate;
    protected $defaultFieldsValidatorInsertContentVersion;
    protected $defaultFieldsValidatorInsertContentVersionProperties;

    protected $defaultValidatorOptionsId;
    protected $defaultValidatorOptionsPublished;
    protected $defaultValidatorOptionsCreatedByUserId;
    protected $defaultValidatorOptionsCreatedReason;
    protected $defaultValidatorOptionsCreatedDate;
    protected $defaultFieldsValidatorOptionsInsertContentVersion;
    protected $defaultFieldsValidatorOptionsInsertContentVersionProperties;

    /**
     * @param BuildFieldValidationResults $buildFieldValidationResults
     * @param ValidateFields              $validateFieldsHasOnlyRecognizedFields
     * @param ValidateIsRealValue         $validateIsRealValue
     * @param string                      $defaultInvalidCode
     * @param string                      $defaultValidatorId
     * @param string                      $defaultValidatorPublished
     * @param string                      $defaultValidatorCreatedByUserId
     * @param string                      $defaultValidatorCreatedReason
     * @param string                      $defaultValidatorCreatedDate
     * @param string                      $defaultFieldsValidatorInsertContentVersion
     * @param string                      $defaultFieldsValidatorInsertContentVersionProperties
     * @param array                       $defaultValidatorOptionsId
     * @param array                       $defaultValidatorOptionsPublished
     * @param array                       $defaultValidatorOptionsCreatedByUserId
     * @param array                       $defaultValidatorOptionsCreatedReason
     * @param array                       $defaultValidatorOptionsCreatedDate
     * @param array                       $defaultFieldsValidatorOptionsInsertContentVersion
     * @param array                       $defaultFieldsValidatorOptionsInsertContentVersionProperties
     */
    public function __construct(
        BuildFieldValidationResults $buildFieldValidationResults,
        ValidateFields $validateFieldsHasOnlyRecognizedFields,
        ValidateIsRealValue $validateIsRealValue,
        string $defaultInvalidCode = self::DEFAULT_INVALID_CODE,
        string $defaultValidatorId = self::DEFAULT_VALIDATOR_ID,
        string $defaultValidatorPublished = self::DEFAULT_VALIDATOR_PUBLISHED,
        string $defaultValidatorCreatedByUserId = self::DEFAULT_VALIDATOR_CREATED_BY_USER_ID,
        string $defaultValidatorCreatedReason = self::DEFAULT_VALIDATOR_CREATED_REASON,
        string $defaultValidatorCreatedDate = self::DEFAULT_VALIDATOR_CREATED_DATE,
        string $defaultFieldsValidatorInsertContentVersion = self::DEFAULT_FIELDS_VALIDATOR_INSERT_CONTENT_VERSION,
        string $defaultFieldsValidatorInsertContentVersionProperties
        = self::DEFAULT_FIELDS_VALIDATOR_INSERT_CONTENT_VERSION_PROPERTIES,
        array $defaultValidatorOptionsId = self::DEFAULT_VALIDATOR_OPTIONS_ID,
        array $defaultValidatorOptionsPublished = self::DEFAULT_VALIDATOR_OPTIONS_PUBLISHED,
        array $defaultValidatorOptionsCreatedByUserId = self::DEFAULT_VALIDATOR_OPTIONS_CREATED_BY_USER_ID,
        array $defaultValidatorOptionsCreatedReason = self::DEFAULT_VALIDATOR_OPTIONS_CREATED_REASON,
        array $defaultValidatorOptionsCreatedDate = self::DEFAULT_VALIDATOR_OPTIONS_CREATED_DATE,
        array $defaultFieldsValidatorOptionsInsertContentVersion
        = self::DEFAULT_FIELDS_VALIDATOR_OPTIONS_INSERT_CONTENT_VERSION,
        $defaultFieldsValidatorOptionsInsertContentVersionProperties
        = self::DEFAULT_FIELDS_VALIDATOR_OPTIONS_INSERT_CONTENT_VERSION_PROPERTIES
    ) {
        $this->buildFieldValidationResults = $buildFieldValidationResults;
        $this->validateFieldsHasOnlyRecognizedFields = $validateFieldsHasOnlyRecognizedFields;
        $this->validateIsRealValue = $validateIsRealValue;
        $this->defaultInvalidCode = $defaultInvalidCode;
        $this->defaultValidatorId = $defaultValidatorId;
        $this->defaultValidatorPublished = $defaultValidatorPublished;
        $this->defaultValidatorCreatedByUserId = $defaultValidatorCreatedByUserId;
        $this->defaultValidatorCreatedReason = $defaultValidatorCreatedReason;
        $this->defaultValidatorCreatedDate = $defaultValidatorCreatedDate;
        $this->defaultFieldsValidatorInsertContentVersion = $defaultFieldsValidatorInsertContentVersion;
        $this->defaultFieldsValidatorInsertContentVersionProperties
            = $defaultFieldsValidatorInsertContentVersionProperties;
        $this->defaultValidatorOptionsId = $defaultValidatorOptionsId;
        $this->defaultValidatorOptionsPublished = $defaultValidatorOptionsPublished;
        $this->defaultValidatorOptionsCreatedByUserId = $defaultValidatorOptionsCreatedByUserId;
        $this->defaultValidatorOptionsCreatedReason = $defaultValidatorOptionsCreatedReason;
        $this->defaultValidatorOptionsCreatedDate = $defaultValidatorOptionsCreatedDate;
        $this->defaultFieldsValidatorOptionsInsertContentVersion = $defaultFieldsValidatorOptionsInsertContentVersion;
        $this->defaultFieldsValidatorOptionsInsertContentVersionProperties
            = $defaultFieldsValidatorOptionsInsertContentVersionProperties;
    }

    /**
     * @param array $cmsResourceData ['{name}' => '{value}']
     * @param array $options
     *
     * @return ValidationResultFields
     * @throws \Exception
     */
    public function __invoke(
        array $cmsResourceData,
        array $options = []
    ): ValidationResultFields {
        $validationsResultOnlyRecognized = $this->validateFieldsHasOnlyRecognizedFields->__invoke(
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

        $fieldResults = $this->getFieldValidationResults(
            $cmsResourceData,
            [],
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

        $validationsResult = new ValidationResultFieldsBasic(
            $valid,
            $code,
            [],
            $fieldResults
        );

        return MergeValidationResultsFields::invoke(
            $validationsResultOnlyRecognized,
            $validationsResult
        );
    }

    /**
     * @param array $cmsResourceData
     * @param array $options
     * @param array $fieldResults
     *
     * @return array
     * @throws \Exception
     */
    protected function getFieldValidationResults(
        array $cmsResourceData,
        array $fieldResults = [],
        array $options = []
    ): array {
        $fieldResults = $this->validateId(
            $cmsResourceData,
            $fieldResults,
            $options
        );

        $fieldResults = $this->validatePublished(
            $cmsResourceData,
            $fieldResults,
            $options
        );

        $fieldResults = $this->validateContentVersion(
            $cmsResourceData,
            $fieldResults,
            $options
        );

        $fieldResults = $this->validateCreatedByUserId(
            $cmsResourceData,
            $fieldResults,
            $options
        );

        $fieldResults = $this->validateCreatedReason(
            $cmsResourceData,
            $fieldResults,
            $options
        );

        $fieldResults = $this->validateCreatedDate(
            $cmsResourceData,
            $fieldResults,
            $options
        );

        return $fieldResults;
    }

    /**
     * @param array $cmsResourceData
     * @param array $fieldResults
     * @param array $options
     *
     * @return array
     * @throws \Exception
     */
    protected function validateId(
        array $cmsResourceData,
        array $fieldResults,
        array $options = []
    ): array {
        return $this->buildFieldValidationResults->__invoke(
            $cmsResourceData,
            $fieldResults,
            self::KEY_ID,
            self::OPTION_VALIDATOR_ID,
            self::OPTION_VALIDATOR_OPTIONS_ID,
            $this->defaultValidatorId,
            $this->defaultValidatorOptionsId,
            $options
        );
    }

    /**
     * @param array $cmsResourceData
     * @param array $fieldResults
     * @param array $options
     *
     * @return array
     * @throws \Exception
     */
    protected function validatePublished(
        array $cmsResourceData,
        array $fieldResults,
        array $options = []
    ): array {
        return $this->buildFieldValidationResults->__invoke(
            $cmsResourceData,
            $fieldResults,
            self::KEY_PUBLISHED,
            self::OPTION_VALIDATOR_PUBLISHED,
            self::OPTION_VALIDATOR_OPTIONS_PUBLISHED,
            $this->defaultValidatorPublished,
            $this->defaultValidatorOptionsPublished,
            $options
        );
    }

    /**
     * @param array $cmsResourceData
     * @param array $fieldResults
     * @param array $options
     *
     * @return array
     * @throws \Exception
     */
    protected function validateContentVersion(
        array $cmsResourceData,
        array $fieldResults,
        array $options = []
    ): array {
        $contentVersion = Property::getArray(
            $cmsResourceData,
            static::KEY_CONTENT_VERSION,
            []
        );

        $contentVersionId = Property::getString(
            $contentVersion,
            'id'
        );

        // Case 1 for Upsert - New Content Version (insert)
        if (empty($contentVersionId)) {
            $options = $this->prepareContentVersionValidatorOptions($options);

            return $this->buildFieldValidationResults->__invoke(
                $cmsResourceData,
                $fieldResults,
                self::KEY_CONTENT_VERSION,
                self::OPTION_FIELDS_VALIDATOR_INSERT_CONTENT_VERSION,
                self::OPTION_FIELDS_VALIDATOR_OPTIONS_INSERT_CONTENT_VERSION,
                $this->defaultFieldsValidatorInsertContentVersion,
                $this->defaultFieldsValidatorOptionsInsertContentVersion,
                $options
            );
        }

        // Case 2 for Upsert - Existing Content Version
        $otherFieldsValidationsResult = $this->validateFieldsHasOnlyRecognizedFields->__invoke(
            $contentVersion,
            [
                ValidateFieldsHasOnlyRecognizedFields::OPTION_FIELDS_ALLOWED => [
                    'id',
                ],
                ValidateFieldsHasOnlyRecognizedFields::OPTION_CODES => [
                    ValidateFieldsHasOnlyRecognizedFields::CODE_UNRECOGNIZED_FIELD
                    => 'content-version-id-is-set-thus-no-other-properties-are-allowed'
                ]
            ]
        );

        $contentVersionIdValidationResult = $this->validateIsRealValue->__invoke(
            $contentVersionId
        );

        $fieldResults[self::KEY_CONTENT_VERSION] = AddValidationResult::invoke(
            $otherFieldsValidationsResult,
            $contentVersionIdValidationResult,
            'id',
            'invalid-content-version-id'
        );

        return $fieldResults;
    }

    /**
     * @param array $options
     *
     * @return array
     */
    protected function prepareContentVersionValidatorOptions(
        array $options = []
    ) {
        // prepare properties options
        $insertContentVersionOptions = Property::getArray(
            $options,
            self::OPTION_FIELDS_VALIDATOR_OPTIONS_INSERT_CONTENT_VERSION,
            []
        );

        $propertyValidator = Property::getString(
            $options,
            self::OPTION_FIELDS_VALIDATOR_INSERT_CONTENT_VERSION_PROPERTIES,
            $this->defaultFieldsValidatorInsertContentVersionProperties
        );

        $insertContentVersionOptions[ValidateFieldsContent::OPTION_FIELDS_VALIDATOR_PROPERTIES]
            = $propertyValidator;

        $propertyValidatorOptions = Property::getArray(
            $options,
            self::OPTION_FIELDS_VALIDATOR_OPTIONS_INSERT_CONTENT_VERSION_PROPERTIES,
            $this->defaultFieldsValidatorOptionsInsertContentVersionProperties
        );

        $insertContentVersionOptions[ValidateFieldsContent::OPTION_FIELDS_VALIDATOR_OPTIONS_PROPERTIES]
            = $propertyValidatorOptions;

        $options[self::OPTION_FIELDS_VALIDATOR_OPTIONS_INSERT_CONTENT_VERSION] = $insertContentVersionOptions;

        return $options;
    }

    /**
     * @param array $cmsResourceData
     * @param array $fieldResults
     * @param array $options
     *
     * @return array
     * @throws \Exception
     */
    protected function validateCreatedByUserId(
        array $cmsResourceData,
        array $fieldResults,
        array $options = []
    ): array {
        return $this->buildFieldValidationResults->__invoke(
            $cmsResourceData,
            $fieldResults,
            self::KEY_CREATED_BY_USER_ID,
            self::OPTION_VALIDATOR_CREATED_BY_USER_ID,
            self::OPTION_VALIDATOR_OPTIONS_CREATED_BY_USER_ID,
            $this->defaultValidatorCreatedByUserId,
            $this->defaultValidatorOptionsCreatedByUserId,
            $options
        );
    }

    /**
     * @param array $cmsResourceData
     * @param array $fieldResults
     * @param array $options
     *
     * @return array
     * @throws \Exception
     */
    protected function validateCreatedReason(
        array $cmsResourceData,
        array $fieldResults,
        array $options = []
    ): array {
        return $this->buildFieldValidationResults->__invoke(
            $cmsResourceData,
            $fieldResults,
            self::KEY_CREATED_REASON,
            self::OPTION_VALIDATOR_CREATED_REASON,
            self::OPTION_VALIDATOR_OPTIONS_CREATED_REASON,
            $this->defaultValidatorCreatedReason,
            $this->defaultValidatorOptionsCreatedReason,
            $options
        );
    }

    /**
     * @param array $cmsResourceData
     * @param array $fieldResults
     * @param array $options
     *
     * @return array
     * @throws \Exception
     */
    protected function validateCreatedDate(
        array $cmsResourceData,
        array $fieldResults,
        array $options = []
    ): array {
        return $this->buildFieldValidationResults->__invoke(
            $cmsResourceData,
            $fieldResults,
            self::KEY_CREATED_DATE,
            self::OPTION_VALIDATOR_CREATED_DATE,
            self::OPTION_VALIDATOR_OPTIONS_CREATED_DATE,
            $this->defaultValidatorCreatedDate,
            $this->defaultValidatorOptionsCreatedDate,
            $options
        );
    }
}
