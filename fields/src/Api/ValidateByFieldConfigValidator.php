<?php

namespace Zrcms\Fields\Api;

use Psr\Container\ContainerInterface;
use Zrcms\InputValidation\Api\Validate;
use Zrcms\InputValidation\Api\ValidateFields;
use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\InputValidation\Model\ValidationResultBasic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateByFieldConfigValidator implements Validate
{
    const OPTION_FIELD_CONFIG_OPTIONS = 'field-config-options';
    const OPTION_FIELD_CONFIG_OPTIONS_VALIDATOR = 'validator';
    const OPTION_FIELD_CONFIG_OPTIONS_VALIDATOR_OPTIONS = 'validator-options';

    protected $serviceContainer;

    /**
     * @param ContainerInterface $serviceContainer
     */
    public function __construct(
        ContainerInterface $serviceContainer
    ) {
        $this->serviceContainer = $serviceContainer;
    }

    /**
     * @param mixed $value
     * @param array $options
     *
     * @return ValidationResult
     * @throws \Exception
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     * @throws \Zrcms\Param\Exception\ParamException
     */
    public function __invoke(
        $value,
        array $options = []
    ): ValidationResult {
        $fieldConfigOptions = Param::getRequired(
            $options,
            static::OPTION_FIELD_CONFIG_OPTIONS
        );

        $validatorServiceName = Param::getString(
            $fieldConfigOptions,
            static::OPTION_FIELD_CONFIG_OPTIONS_VALIDATOR
        );

        if (empty($validatorServiceName)) {
            // No validator means nothing to validate
            return new ValidationResultBasic();
        }

        /** @var Validate|ValidateFields $validator */
        $validator = $this->serviceContainer->get($validatorServiceName);

        return $validator->__invoke(
            $value,
            Param::getArray(
                $fieldConfigOptions,
                static::OPTION_FIELD_CONFIG_OPTIONS_VALIDATOR_OPTIONS,
                []
            )
        );
    }
}
