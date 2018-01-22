<?php

namespace Zrcms\InputValidation\Api;

use Psr\Container\ContainerInterface;
use Zrcms\InputValidation\Exception\ValidateApiInvalid;
use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\InputValidation\Model\ValidationResultBasic;
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

        $valid = true;
        $code = '';
        $fieldResults = [];

        foreach ($fields as $fieldName => $value) {
            $validationResult = $this->validate(
                $fieldName,
                $value,
                $fieldValidatorConfig
            );

            if (!$validationResult->isValid()) {
                $valid = false;
                $code = Param::getString(
                    $options,
                    static::OPTION_INVALID_CODE,
                    $this->defaultInvalidCode
                );
            }

            $fieldResults[$fieldName] = $validationResult;
        }

        return new ValidationResultFieldsBasic(
            $valid,
            $code,
            [],
            $fieldResults
        );
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
        string  $validateApiServiceName
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
            return $this->buildFieldNotRecognizedResult(
                $fieldName,
                $value,
                $fieldValidatorConfig
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

    /**
     * This is here in case the need to be over-ridden
     *
     * @param string $fieldName
     * @param mixed  $value
     * @param array  $validationConfig
     *
     * @return ValidationResultBasic
     */
    protected function buildFieldNotRecognizedResult(
        string $fieldName,
        $value,
        array $validationConfig
    ) {
        return new ValidationResultBasic(
            false,
            self::CODE_UNRECOGNIZED_FIELD,
            ['message' => 'Unrecognized field received: (' . $fieldName . ')']
        );
    }
}
