<?php

namespace Zrcms\InputValidation\Api;

use Psr\Container\ContainerInterface;
use Zrcms\InputValidation\Exception\ValidateApiInvalid;
use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\InputValidation\Model\ValidationResultFields;
use Zrcms\InputValidation\Model\ValidationResultFieldsBasic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateFieldsByStrategy implements ValidateFields
{
    const CODE_UNRECOGNIZED_FIELD = 'unrecognized-field';

    const OPTION_FIELD_VALIDATORS = 'field-validators';
    const OPTION_INVALID_CODE = 'code-invalid';

    const DEFAULT_INVALID_CODE = 'invalid';

    protected $serviceContainer;
    protected $validate;
    protected $defaultInvalidCode;

    /**
     * @param ContainerInterface $serviceContainer
     * @param ValidateByStrategy $validate
     * @param string             $defaultInvalidCode
     */
    public function __construct(
        ContainerInterface $serviceContainer,
        ValidateByStrategy $validate,
        string $defaultInvalidCode = self::DEFAULT_INVALID_CODE
    ) {
        $this->serviceContainer = $serviceContainer;
        $this->validate = $validate;
        $this->defaultInvalidCode = $defaultInvalidCode;
    }

    /**
     * Validation Config Example
     * [
     *  '{field-name}' => [
     *   'validator' => '{Validate or ValidateFields}',
     *   'options' => [],
     *  ]
     * ]
     *
     * @param array $fields ['{name}' => '{value}']
     * @param array $options
     *
     * @return ValidationResultFields
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     * @throws \Zrcms\InputValidation\Exception\ValidateApiInvalid
     * @throws \Zrcms\Param\Exception\ParamException
     */
    public function __invoke(
        array $fields,
        array $options = []
    ): ValidationResultFields {
        Param::assertNotEmpty(
            $options,
            static::OPTION_FIELD_VALIDATORS
        );

        $fieldValidatorConfig = Param::getArray(
            $options,
            static::OPTION_FIELD_VALIDATORS
        );

        $fieldResults = $this->getFieldValidationResults(
            $fields,
            $fieldValidatorConfig
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
     * @param array $fields
     * @param array $fieldValidatorConfig
     * @param array $fieldResults
     *
     * @return array
     * @throws ValidateApiInvalid
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     * @throws \Zrcms\Param\Exception\ParamException
     */
    protected function getFieldValidationResults(
        array $fields,
        array $fieldValidatorConfig = [],
        array $fieldResults = []
    ): array {
        foreach ($fields as $fieldName => $value) {
            $fieldResults[$fieldName] = $this->validate(
                $fieldName,
                $value,
                $fieldValidatorConfig
            );
        }

        return $fieldResults;
    }

    /**
     * @param string $validateApiServiceName
     *
     * @return mixed|Validate|ValidateFields
     * @throws ValidateApiInvalid
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    protected function getValidateApi(
        string $validateApiServiceName
    ) {
        if (!$this->serviceContainer->has($validateApiServiceName)) {
            throw new ValidateApiInvalid(
                'Validation service not found: (' . $validateApiServiceName . ')'
            );
        }

        /** @var Validate|ValidateFields $validateApi */
        $validateApi = $this->serviceContainer->get($validateApiServiceName);

        if (!$validateApi instanceof Validate && !$validateApi instanceof ValidateFields) {
            throw new ValidateApiInvalid(
                'Validation service must be instance of: (' . Validate::class . ')'
                . ' or instance of: (' . ValidateFields::class . ')'
                . ' got: (' . get_class($validateApi) . ')'
            );
        }

        return $validateApi;
    }

    /**
     * @param string $fieldName
     * @param mixed  $value
     * @param array  $fieldValidatorConfig
     *
     * @return ValidationResult
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     * @throws \Zrcms\InputValidation\Exception\ValidateApiInvalid
     * @throws \Zrcms\Param\Exception\ParamException
     */
    protected function validate(
        string $fieldName,
        $value,
        array $fieldValidatorConfig
    ): ValidationResult {
        if (!array_key_exists($fieldName, $fieldValidatorConfig)) {
            return BuildFieldNotRecognizedResult::invoke(
                $fieldName
            );
        }

        $validatorConfig = Param::getArray(
            $fieldValidatorConfig,
            $fieldName,
            []
        );

        $validateApiServiceName = Param::getRequired(
            $validatorConfig,
            ValidateByStrategy::OPTION_VALIDATE_API
        );

        $validateApiOptions = Param::getRequired(
            $validatorConfig,
            ValidateByStrategy::OPTION_VALIDATE_API_OPTIONS
        );

        $validateApi = $this->getValidateApi(
            $validateApiServiceName
        );

        return $validateApi->__invoke(
            $value,
            $validateApiOptions
        );
    }
}
