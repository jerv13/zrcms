<?php

namespace Zrcms\ValidationRatZrcms\Api\FieldValidator;

use Reliv\ValidationRat\Api\BuildCode;
use Reliv\ValidationRat\Api\FieldValidator\ValidateFields;
use Reliv\ValidationRat\Api\FieldValidator\ValidateFieldsHasOnlyRecognizedFields;
use Reliv\ValidationRat\Api\IsValidFieldResults;
use Reliv\ValidationRat\Api\Validator\ValidateCompositeByStrategy;
use Reliv\ValidationRat\Api\Validator\ValidateIsNotEmpty;
use Reliv\ValidationRat\Api\Validator\ValidateIsNull;
use Reliv\ValidationRat\Api\Validator\ValidateIsString;
use Reliv\ValidationRat\Model\ValidationResultFields;
use Reliv\ValidationRat\Model\ValidationResultFieldsBasic;
use Zrcms\ValidationRatZrcms\Api\Validator\ValidateContentVersionId;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateFieldsInsertContentVersionData implements ValidateFieldsContent
{
    //const KEY_ID = ValidateFieldsContent::KEY_ID;
    //const KEY_PROPERTIES = ValidateFieldsContent::KEY_PROPERTIES;
    //const KEY_CREATED_BY_USER_ID = ValidateFieldsContent::KEY_CREATED_BY_USER_ID;
    //const KEY_CREATED_REASON = ValidateFieldsContent::KEY_CREATED_REASON;
    //const KEY_CREATED_DATE = ValidateFieldsContent::KEY_CREATED_DATE;

    const OPTION_INVALID_CODE = BuildCode::OPTION_INVALID_CODE;

    const OPTION_VALIDATOR_ID = 'validator-id';
    const OPTION_VALIDATOR_OPTIONS_ID = 'validator-options-id';

    const OPTION_VALIDATOR_CREATED_BY_USER_ID = 'validator-created-by-user-id';
    const OPTION_VALIDATOR_OPTIONS_CREATED_BY_USER_ID = 'validator-options-created-by-user-id';

    const OPTION_VALIDATOR_CREATED_REASON = 'validator-created-reason';
    const OPTION_VALIDATOR_OPTIONS_CREATED_REASON = 'validator-options-created-reason';

    const OPTION_VALIDATOR_CREATED_DATE = 'validator-created-date';
    const OPTION_VALIDATOR_OPTIONS_CREATED_DATE = 'validator-options-created-date';

    //const OPTION_FIELDS_VALIDATOR_PROPERTIES
    //    = ValidateFieldsContent::OPTION_FIELDS_VALIDATOR_PROPERTIES;
    //const OPTION_FIELDS_VALIDATOR_OPTIONS_PROPERTIES
    //    = ValidateFieldsContent::OPTION_FIELDS_VALIDATOR_OPTIONS_PROPERTIES;

    const DEFAULT_INVALID_CODE = 'invalid-content-version';

    const DEFAULT_VALIDATOR_ID = ValidateContentVersionId::class;
    const DEFAULT_VALIDATOR_OPTIONS_ID = [];

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

    const DEFAULT_FIELDS_VALIDATOR_PROPERTIES = ValidateFieldsContentVersionProperties::class;
    const DEFAULT_FIELDS_VALIDATOR_OPTIONS_PROPERTIES = [];

    protected $buildFieldValidationResults;
    protected $validateFieldsHasOnlyRecognizedFields;
    protected $defaultInvalidCode;

    protected $defaultValidatorId;
    protected $defaultValidatorCreatedByUserId;
    protected $defaultValidatorCreatedReason;
    protected $defaultValidatorCreatedDate;
    protected $defaultFieldsValidatorProperties;

    protected $defaultValidatorOptionsId;
    protected $defaultValidatorOptionsCreatedByUserId;
    protected $defaultValidatorOptionsCreatedReason;
    protected $defaultValidatorOptionsCreatedDate;
    protected $defaultFieldsValidatorOptionsProperties;

    /**
     * @param BuildFieldValidationResults $buildFieldValidationResults
     * @param ValidateFields              $validateFieldsHasOnlyRecognizedFields
     * @param string                      $defaultInvalidCode
     * @param string                      $defaultValidatorId
     * @param string                      $defaultValidatorCreatedByUserId
     * @param string                      $defaultValidatorCreatedReason
     * @param string                      $defaultValidatorCreatedDate
     * @param string                      $defaultFieldsValidatorProperties
     * @param array                       $defaultValidatorOptionsId
     * @param array                       $defaultValidatorOptionsCreatedByUserId
     * @param array                       $defaultValidatorOptionsCreatedReason
     * @param array                       $defaultValidatorOptionsCreatedDate
     * @param array                       $defaultFieldsValidatorOptionsProperties
     */
    public function __construct(
        BuildFieldValidationResults $buildFieldValidationResults,
        ValidateFields $validateFieldsHasOnlyRecognizedFields,
        string $defaultInvalidCode = self::DEFAULT_INVALID_CODE,
        string $defaultValidatorId = self::DEFAULT_VALIDATOR_ID,
        string $defaultValidatorCreatedByUserId = self::DEFAULT_VALIDATOR_CREATED_BY_USER_ID,
        string $defaultValidatorCreatedReason = self::DEFAULT_VALIDATOR_CREATED_REASON,
        string $defaultValidatorCreatedDate = self::DEFAULT_VALIDATOR_CREATED_DATE,
        string $defaultFieldsValidatorProperties = self::DEFAULT_FIELDS_VALIDATOR_PROPERTIES,
        array $defaultValidatorOptionsId = self::DEFAULT_VALIDATOR_OPTIONS_ID,
        array $defaultValidatorOptionsCreatedByUserId = self::DEFAULT_VALIDATOR_OPTIONS_CREATED_BY_USER_ID,
        array $defaultValidatorOptionsCreatedReason = self::DEFAULT_VALIDATOR_OPTIONS_CREATED_REASON,
        array $defaultValidatorOptionsCreatedDate = self::DEFAULT_VALIDATOR_OPTIONS_CREATED_DATE,
        array $defaultFieldsValidatorOptionsProperties = self::DEFAULT_FIELDS_VALIDATOR_OPTIONS_PROPERTIES
    ) {
        $this->buildFieldValidationResults = $buildFieldValidationResults;
        $this->validateFieldsHasOnlyRecognizedFields = $validateFieldsHasOnlyRecognizedFields;
        $this->defaultInvalidCode = $defaultInvalidCode;
        $this->defaultValidatorId = $defaultValidatorId;
        $this->defaultValidatorCreatedByUserId = $defaultValidatorCreatedByUserId;
        $this->defaultValidatorCreatedReason = $defaultValidatorCreatedReason;
        $this->defaultValidatorCreatedDate = $defaultValidatorCreatedDate;
        $this->defaultFieldsValidatorProperties = $defaultFieldsValidatorProperties;
        $this->defaultValidatorOptionsId = $defaultValidatorOptionsId;
        $this->defaultValidatorOptionsCreatedByUserId = $defaultValidatorOptionsCreatedByUserId;
        $this->defaultValidatorOptionsCreatedReason = $defaultValidatorOptionsCreatedReason;
        $this->defaultValidatorOptionsCreatedDate = $defaultValidatorOptionsCreatedDate;
        $this->defaultFieldsValidatorOptionsProperties = $defaultFieldsValidatorOptionsProperties;
    }

    /**
     * @param array $contentVersionData ['{name}' => '{value}']
     * @param array $options
     *
     * @return ValidationResultFields
     * @throws \Exception
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

        $fieldResults = $this->getFieldValidationResults(
            $contentVersionData,
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
     * @throws \Exception
     */
    protected function getFieldValidationResults(
        array $contentVersionData,
        array $options = [],
        array $fieldResults = []
    ): array {
        $fieldResults = $this->validateId(
            $contentVersionData,
            $fieldResults,
            $options
        );

        $fieldResults = $this->validateProperties(
            $contentVersionData,
            $fieldResults,
            $options
        );

        $fieldResults = $this->validateCreatedByUserId(
            $contentVersionData,
            $fieldResults,
            $options
        );

        $fieldResults = $this->validateCreatedReason(
            $contentVersionData,
            $fieldResults,
            $options
        );

        $fieldResults = $this->validateCreatedDate(
            $contentVersionData,
            $fieldResults,
            $options
        );

        return $fieldResults;
    }

    /**
     * @param array $contentVersionData
     * @param array $fieldResults
     * @param array $options
     *
     * @return array
     * @throws \Exception
     */
    protected function validateId(
        array $contentVersionData,
        array $fieldResults,
        array $options = []
    ): array {
        return $this->buildFieldValidationResults->__invoke(
            $contentVersionData,
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
     * @param array $contentVersionData
     * @param array $fieldResults
     * @param array $options
     *
     * @return array
     * @throws \Exception
     */
    protected function validateProperties(
        array $contentVersionData,
        array $fieldResults,
        array $options = []
    ): array {
        return $this->buildFieldValidationResults->__invoke(
            $contentVersionData,
            $fieldResults,
            self::KEY_PROPERTIES,
            self::OPTION_FIELDS_VALIDATOR_PROPERTIES,
            self::OPTION_FIELDS_VALIDATOR_OPTIONS_PROPERTIES,
            $this->defaultFieldsValidatorProperties,
            $this->defaultFieldsValidatorOptionsProperties,
            $options
        );
    }

    /**
     * @param array $contentVersionData
     * @param array $fieldResults
     * @param array $options
     *
     * @return array
     * @throws \Exception
     */
    protected function validateCreatedByUserId(
        array $contentVersionData,
        array $fieldResults,
        array $options = []
    ): array {
        return $this->buildFieldValidationResults->__invoke(
            $contentVersionData,
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
     * @param array $contentVersionData
     * @param array $fieldResults
     * @param array $options
     *
     * @return array
     * @throws \Exception
     */
    protected function validateCreatedReason(
        array $contentVersionData,
        array $fieldResults,
        array $options = []
    ): array {
        return $this->buildFieldValidationResults->__invoke(
            $contentVersionData,
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
     * @param array $contentVersionData
     * @param array $fieldResults
     * @param array $options
     *
     * @return array
     * @throws \Exception
     */
    protected function validateCreatedDate(
        array $contentVersionData,
        array $fieldResults,
        array $options = []
    ): array {
        return $this->buildFieldValidationResults->__invoke(
            $contentVersionData,
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
