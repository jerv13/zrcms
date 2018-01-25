<?php

namespace Zrcms\InputValidationZrcms\Api;

use Psr\Container\ContainerInterface;
use Zrcms\InputValidation\Api\Validate;
use Zrcms\InputValidation\Api\ValidateCompositeByStrategy;
use Zrcms\InputValidation\Api\ValidateFields;
use Zrcms\InputValidation\Api\ValidateFieldsHasOnlyRecognizedFields;
use Zrcms\InputValidation\Api\ValidateIsAssociativeArray;
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
class ValidateContentVersionData implements ValidateFields
{
    const KEY_ID = 'id';
    const KEY_PROPERTIES = 'properties';
    const KEY_CREATED_BY_USER_ID = 'createdByUserId';
    const KEY_CREATED_REASON = 'createdReason';
    const KEY_CREATED_DATE = 'createdDate';

    const OPTION_INVALID_CODE = 'code-invalid';

    const DEFAULT_INVALID_CODE = 'invalid-content-version';

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

        $fieldResults = $this->getFieldValidationResults(
            $contentVersionData,
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
     * @param array $contentVersionData
     * @param array $fieldResults
     * @param array $options
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function validateId(
        array $contentVersionData,
        array $fieldResults,
        array $options = []
    ): array {
        /** @var Validate $validator */
        $validator = $this->serviceContainer->get(ValidateIsNull::class);

        $fieldResults[static::KEY_ID] = $validator->__invoke(
            Param::get(
                $contentVersionData,
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
     * @param array $contentVersionData
     * @param array $fieldResults
     * @param array $options
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function validateProperties(
        array $contentVersionData,
        array $fieldResults,
        array $options = []
    ): array {
        /** @var Validate $validator */
        $validator = $this->serviceContainer->get(ValidateIsAssociativeArray::class);

        $fieldResults[static::KEY_PROPERTIES] = $validator->__invoke(
            Param::getArray(
                $contentVersionData,
                static::KEY_PROPERTIES
            ),
            Param::getArray(
                $options,
                static::KEY_PROPERTIES,
                []
            )
        );

        return $fieldResults;
    }

    /**
     * @param array $contentVersionData
     * @param array $fieldResults
     * @param array $options
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function validateCreatedByUserId(
        array $contentVersionData,
        array $fieldResults,
        array $options = []
    ): array {
        /** @var Validate $validator */
        $validator = $this->serviceContainer->get(ValidateIsNull::class);

        $fieldResults[static::KEY_CREATED_BY_USER_ID] = $validator->__invoke(
            Param::get(
                $contentVersionData,
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
     * @param array $contentVersionData
     * @param array $fieldResults
     * @param array $options
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function validateCreatedReason(
        array $contentVersionData,
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
     * @param array $options
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function validateCreatedDate(
        array $contentVersionData,
        array $fieldResults,
        array $options = []
    ): array {
        /** @var Validate $validator */
        $validator = $this->serviceContainer->get(ValidateIsNull::class);

        $fieldResults[static::KEY_CREATED_DATE] = $validator->__invoke(
            Param::get(
                $contentVersionData,
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
