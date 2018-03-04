<?php

namespace Zrcms\ValidationRatZrcms\Api\FieldValidator;

use Reliv\ValidationRat\Api\BuildCode;
use Reliv\ValidationRat\Api\FieldValidator\ValidateFields;
use Reliv\ValidationRat\Api\FieldValidator\ValidateFieldsHasOnlyRecognizedFields;
use Reliv\ValidationRat\Api\IsValidFieldResults;
use Reliv\ValidationRat\Api\MergeValidationResultsFields;
use Reliv\ValidationRat\Api\Validator\ValidateCompositeByStrategy;
use Reliv\ValidationRat\Api\Validator\ValidateIsBoolean;
use Reliv\ValidationRat\Api\Validator\ValidateIsNotEmpty;
use Reliv\ValidationRat\Api\Validator\ValidateIsNull;
use Reliv\ValidationRat\Api\Validator\ValidateIsString;
use Reliv\ValidationRat\Model\ValidationResultFields;
use Reliv\ValidationRat\Model\ValidationResultFieldsBasic;
use Zrcms\ValidationRatZrcms\Api\Validator\ValidateCmsResourceId;
use Zrcms\ValidationRatZrcms\Api\Validator\ValidateContentVersionExists;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateFieldsUpsertCmsResourceData implements ValidateFields
{
    const KEY_ID = 'id';
    const KEY_PUBLISHED = 'published';
    const KEY_CONTENT_VERSION_ID = 'contentVersionId';
    const KEY_CREATED_BY_USER_ID = 'createdByUserId';
    const KEY_CREATED_REASON = 'createdReason';
    const KEY_CREATED_DATE = 'createdDate';

    const OPTION_INVALID_CODE = BuildCode::OPTION_INVALID_CODE;

    const OPTION_VALIDATOR_ID = 'validator-id';
    const OPTION_VALIDATOR_OPTIONS_ID = 'validator-options-id';

    const OPTION_VALIDATOR_PUBLISHED = 'validator-published';
    const OPTION_VALIDATOR_OPTIONS_PUBLISHED = 'validator-options-published';

    const OPTION_VALIDATOR_CONTENT_VERSION_ID = 'validator-content-version-id';
    const OPTION_VALIDATOR_OPTIONS_CONTENT_VERSION_ID = 'validator-options-content-version-id';

    const OPTION_VALIDATOR_CREATED_BY_USER_ID = 'validator-created-by-user-id';
    const OPTION_VALIDATOR_OPTIONS_CREATED_BY_USER_ID = 'validator-options-created-by-user-id';

    const OPTION_VALIDATOR_CREATED_REASON = 'validator-created-reason';
    const OPTION_VALIDATOR_OPTIONS_CREATED_REASON = 'validator-options-created-reason';

    const OPTION_VALIDATOR_CREATED_DATE = 'validator-created-date';
    const OPTION_VALIDATOR_OPTIONS_CREATED_DATE = 'validator-options-created-date';

    const DEFAULT_INVALID_CODE = 'invalid-cms-resource';

    const DEFAULT_VALIDATOR_ID = ValidateCmsResourceId::class;
    const DEFAULT_VALIDATOR_OPTIONS_ID = [];

    const DEFAULT_VALIDATOR_PUBLISHED = ValidateIsBoolean::class;
    const DEFAULT_VALIDATOR_OPTIONS_PUBLISHED = [];

    const DEFAULT_VALIDATOR_CONTENT_VERSION_ID = ValidateContentVersionExists::class;
    const DEFAULT_VALIDATOR_OPTIONS_CONTENT_VERSION_ID
        = [
            // NOTE: this is required by caller
            ValidateContentVersionExists::OPTION_API_SERVICE_FIND_CONTENT_VERSION => null,
        ];

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

    protected $buildFieldValidationResults;
    protected $validateFieldsHasOnlyRecognizedFields;
    protected $defaultInvalidCode;

    protected $defaultValidatorId;
    protected $defaultValidatorPublished;
    protected $defaultValidatorContentVersionId;
    protected $defaultValidatorCreatedByUserId;
    protected $defaultValidatorCreatedReason;
    protected $defaultValidatorCreatedDate;

    protected $defaultValidatorOptionsId;
    protected $defaultValidatorOptionsPublished;
    protected $defaultValidatorOptionsCreatedByUserId;
    protected $defaultValidatorOptionsCreatedReason;
    protected $defaultValidatorOptionsCreatedDate;
    protected $defaultValidatorOptionsContentVersionId;

    /**
     * @param BuildFieldValidationResults $buildFieldValidationResults
     * @param ValidateFields              $validateFieldsHasOnlyRecognizedFields
     * @param string                      $defaultInvalidCode
     * @param string                      $defaultValidatorId
     * @param string                      $defaultValidatorPublished
     * @param string                      $defaultValidatorContentVersionId
     * @param string                      $defaultValidatorCreatedByUserId
     * @param string                      $defaultValidatorCreatedReason
     * @param string                      $defaultValidatorCreatedDate
     * @param array                       $defaultValidatorOptionsId
     * @param array                       $defaultValidatorOptionsPublished
     * @param array                       $defaultValidatorOptionsContentVersionId
     * @param array                       $defaultValidatorOptionsCreatedByUserId
     * @param array                       $defaultValidatorOptionsCreatedReason
     * @param array                       $defaultValidatorOptionsCreatedDate
     */
    public function __construct(
        BuildFieldValidationResults $buildFieldValidationResults,
        ValidateFields $validateFieldsHasOnlyRecognizedFields,
        string $defaultInvalidCode = self::DEFAULT_INVALID_CODE,
        string $defaultValidatorId = self::DEFAULT_VALIDATOR_ID,
        string $defaultValidatorPublished = self::DEFAULT_VALIDATOR_PUBLISHED,
        string $defaultValidatorContentVersionId = self::DEFAULT_VALIDATOR_CONTENT_VERSION_ID,
        string $defaultValidatorCreatedByUserId = self::DEFAULT_VALIDATOR_CREATED_BY_USER_ID,
        string $defaultValidatorCreatedReason = self::DEFAULT_VALIDATOR_CREATED_REASON,
        string $defaultValidatorCreatedDate = self::DEFAULT_VALIDATOR_CREATED_DATE,
        array $defaultValidatorOptionsId = self::DEFAULT_VALIDATOR_OPTIONS_ID,
        array $defaultValidatorOptionsPublished = self::DEFAULT_VALIDATOR_OPTIONS_PUBLISHED,
        array $defaultValidatorOptionsContentVersionId = self::DEFAULT_VALIDATOR_OPTIONS_CONTENT_VERSION_ID,
        array $defaultValidatorOptionsCreatedByUserId = self::DEFAULT_VALIDATOR_OPTIONS_CREATED_BY_USER_ID,
        array $defaultValidatorOptionsCreatedReason = self::DEFAULT_VALIDATOR_OPTIONS_CREATED_REASON,
        array $defaultValidatorOptionsCreatedDate = self::DEFAULT_VALIDATOR_OPTIONS_CREATED_DATE
    ) {
        $this->buildFieldValidationResults = $buildFieldValidationResults;
        $this->validateFieldsHasOnlyRecognizedFields = $validateFieldsHasOnlyRecognizedFields;

        $this->defaultInvalidCode = $defaultInvalidCode;
        $this->defaultValidatorId = $defaultValidatorId;
        $this->defaultValidatorPublished = $defaultValidatorPublished;
        $this->defaultValidatorContentVersionId = $defaultValidatorContentVersionId;
        $this->defaultValidatorCreatedByUserId = $defaultValidatorCreatedByUserId;
        $this->defaultValidatorCreatedReason = $defaultValidatorCreatedReason;
        $this->defaultValidatorCreatedDate = $defaultValidatorCreatedDate;

        $this->defaultValidatorOptionsId = $defaultValidatorOptionsId;
        $this->defaultValidatorOptionsPublished = $defaultValidatorOptionsPublished;
        $this->defaultValidatorOptionsContentVersionId = $defaultValidatorOptionsContentVersionId;
        $this->defaultValidatorOptionsCreatedByUserId = $defaultValidatorOptionsCreatedByUserId;
        $this->defaultValidatorOptionsCreatedReason = $defaultValidatorOptionsCreatedReason;
        $this->defaultValidatorOptionsCreatedDate = $defaultValidatorOptionsCreatedDate;
    }

    /**
     * @param array $cmsResourceData
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
                    static::KEY_CONTENT_VERSION_ID,
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
     * @param array $fieldResults
     * @param array $options
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

        $fieldResults = $this->validateContentVersionId(
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
    protected function validateContentVersionId(
        array $cmsResourceData,
        array $fieldResults,
        array $options = []
    ): array {
        return $this->buildFieldValidationResults->__invoke(
            $cmsResourceData,
            $fieldResults,
            self::KEY_CONTENT_VERSION_ID,
            self::OPTION_VALIDATOR_CONTENT_VERSION_ID,
            self::OPTION_VALIDATOR_OPTIONS_CONTENT_VERSION_ID,
            $this->defaultValidatorContentVersionId,
            $this->defaultValidatorOptionsContentVersionId,
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
