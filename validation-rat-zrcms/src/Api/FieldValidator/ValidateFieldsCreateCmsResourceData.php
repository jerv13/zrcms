<?php

namespace Zrcms\ValidationRatZrcms\Api\FieldValidator;

use Reliv\ValidationRat\Api\FieldValidator\ValidateFields;
use Reliv\ValidationRat\Api\Validator\ValidateIsStringOrNull;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateFieldsCreateCmsResourceData extends ValidateFieldsUpdateCmsResourceData
{
    const DEFAULT_VALIDATOR_ID = ValidateIsStringOrNull::class;
    const DEFAULT_VALIDATOR_OPTIONS_ID = [];

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
        parent::__construct(
            $buildFieldValidationResults,
            $validateFieldsHasOnlyRecognizedFields,
            $defaultInvalidCode,
            $defaultValidatorId,
            $defaultValidatorPublished,
            $defaultValidatorContentVersionId,
            $defaultValidatorCreatedByUserId,
            $defaultValidatorCreatedReason,
            $defaultValidatorCreatedDate,
            $defaultValidatorOptionsId,
            $defaultValidatorOptionsPublished,
            $defaultValidatorOptionsContentVersionId,
            $defaultValidatorOptionsCreatedByUserId,
            $defaultValidatorOptionsCreatedReason,
            $defaultValidatorOptionsCreatedDate
        );
    }
}
