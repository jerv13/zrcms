<?php

namespace Zrcms\InputValidationZrcms\Api;

use Psr\Container\ContainerInterface;
use Zrcms\InputValidation\Api\Validate;
use Zrcms\InputValidation\Api\ValidateCompositeByStrategy;
use Zrcms\InputValidation\Api\ValidateFields;
use Zrcms\InputValidation\Api\ValidateFieldsHasOnlyRecognizedFields;
use Zrcms\InputValidation\Api\ValidateIsAnyValue;
use Zrcms\InputValidation\Api\ValidateIsBoolean;
use Zrcms\InputValidation\Api\ValidateIsNotEmpty;
use Zrcms\InputValidation\Api\ValidateIsNull;
use Zrcms\InputValidation\Api\ValidateIsString;
use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\InputValidation\Model\ValidationResultFields;
use Zrcms\InputValidation\Model\ValidationResultFieldsBasic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateCmsResourceData implements ValidateFields
{
    const KEY_ID = 'id';
    const KEY_PUBLISHED = 'published';
    const KEY_CONTENT_VERSION = 'contentVersion';
    const KEY_CREATED_BY_USER_ID = 'createdByUserId';
    const KEY_CREATED_REASON = 'createdReason';
    const KEY_CREATED_DATE = 'createdDate';

    const OPTION_INVALID_CODE = 'code-invalid';

    const DEFAULT_INVALID_CODE = 'invalid-cms-resource';

    protected $serviceContainer;
    protected $validateFieldsHasOnlyRecognizedFields;
    protected $validateContentVersion;
    protected $defaultInvalidCode;

    /**
     * @param ContainerInterface                                   $serviceContainer
     * @param ValidateFields|ValidateFieldsHasOnlyRecognizedFields $validateFieldsHasOnlyRecognizedFields
     * @param ValidateFields                                       $validateContentVersion
     * @param string                                               $defaultInvalidCode
     */
    public function __construct(
        ContainerInterface $serviceContainer,
        ValidateFields $validateFieldsHasOnlyRecognizedFields,
        ValidateFields $validateContentVersion,
        string $defaultInvalidCode = self::DEFAULT_INVALID_CODE
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->validateFieldsHasOnlyRecognizedFields = $validateFieldsHasOnlyRecognizedFields;
        $this->validateContentVersion = $validateContentVersion;
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

        $fieldResults = $this->getFieldValidationResults(
            $cmsResourceData,
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
     * @param array $cmsResourceData
     * @param array $options
     * @param array $fieldResults
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function getFieldValidationResults(
        array $cmsResourceData,
        array $options = [],
        array $fieldResults = []
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

    /**
     * @param array $cmsResourceData
     * @param array $fieldResults
     * @param array $options
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function validateId(
        array $cmsResourceData,
        array $fieldResults,
        array $options = []
    ): array {
        /** @var Validate $validator */
        $validator = $this->serviceContainer->get(ValidateIsAnyValue::class);

        $fieldResults[static::KEY_ID] = $validator->__invoke(
            Param::get(
                $cmsResourceData,
                static::KEY_ID
            ),
            Param::getArray(
                $options,
                static::KEY_ID,
                []
            )
        );

        return $fieldResults;
    }

    /**
     * @param array $cmsResourceData
     * @param array $fieldResults
     * @param array $options
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function validatePublished(
        array $cmsResourceData,
        array $fieldResults,
        array $options = []
    ): array {
        /** @var Validate $validator */
        $validator = $this->serviceContainer->get(ValidateIsBoolean::class);

        $fieldResults[static::KEY_PUBLISHED] = $validator->__invoke(
            Param::getBool(
                $cmsResourceData,
                static::KEY_PUBLISHED
            ),
            Param::getArray(
                $options,
                static::KEY_PUBLISHED,
                []
            )
        );

        return $fieldResults;
    }

    /**
     * @param array $cmsResourceData
     * @param array $fieldResults
     * @param array $options
     *
     * @return array
     */
    protected function validateContentVersion(
        array $cmsResourceData,
        array $fieldResults,
        array $options = []
    ): array {
        $fieldResults[static::KEY_CONTENT_VERSION] = $this->validateContentVersion->__invoke(
            Param::getArray(
                $cmsResourceData,
                static::KEY_CONTENT_VERSION,
                []
            ),
            Param::getArray(
                $options,
                static::KEY_CONTENT_VERSION,
                []
            )
        );

        return $fieldResults;
    }

    /**
     * @param array $cmsResourceData
     * @param array $fieldResults
     * @param array $options
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function validateCreatedByUserId(
        array $cmsResourceData,
        array $fieldResults,
        array $options = []
    ): array {
        /** @var Validate $validator */
        $validator = $this->serviceContainer->get(ValidateIsNull::class);

        $fieldResults[static::KEY_CREATED_BY_USER_ID] = $validator->__invoke(
            Param::get(
                $cmsResourceData,
                static::KEY_CREATED_BY_USER_ID
            ),
            Param::getArray(
                $options,
                static::KEY_CREATED_BY_USER_ID,
                []
            )
        );

        return $fieldResults;
    }

    /**
     * @param array $cmsResourceData
     * @param array $fieldResults
     * @param array $options
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function validateCreatedReason(
        array $cmsResourceData,
        array $fieldResults,
        array $options = []
    ): array {
        /** @var Validate $validator */
        $validator = $this->serviceContainer->get(ValidateCompositeByStrategy::class);

        $validatorOptions = Param::getArray(
            $options,
            static::KEY_CREATED_REASON,
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
     * @param array $options
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function validateCreatedDate(
        array $cmsResourceData,
        array $fieldResults,
        array $options = []
    ): array {
        /** @var Validate $validator */
        $validator = $this->serviceContainer->get(ValidateIsNull::class);

        $fieldResults[static::KEY_CREATED_DATE] = $validator->__invoke(
            Param::get(
                $cmsResourceData,
                static::KEY_CREATED_DATE
            ),
            Param::getArray(
                $options,
                static::KEY_CREATED_DATE,
                []
            )
        );

        return $fieldResults;
    }
}
