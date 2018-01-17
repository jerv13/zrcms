<?php

namespace Zrcms\InputValidation\Api;

use Psr\Container\ContainerInterface;
use Zrcms\InputValidation\Exception\ValidateApiInvalid;
use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateByStrategy implements Validate
{
    const OPTION_VALIDATE_API = 'validate-api';
    const OPTION_VALIDATE_API_OPTIONS = 'validate-api-options';

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
     * @throws ValidateApiInvalid
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     * @throws \Zrcms\Param\Exception\ParamException
     */
    public function __invoke(
        $value,
        array $options = []
    ): ValidationResult {
        $validateApiServiceName = Param::getRequired(
            $options,
            static::OPTION_VALIDATE_API
        );

        if (!$this->serviceContainer->has($validateApiServiceName)) {
            throw new ValidateApiInvalid(
                'Validation service not found: (' . $validateApiServiceName . ')'
            );
        }

        /** @var Validate $validateApi */
        $validateApi = $this->serviceContainer->get($validateApiServiceName);

        if (!$validateApi instanceof Validate) {
            throw new ValidateApiInvalid(
                'Validation service must be instance of: (' . Validate::class . ')'
            );
        }

        $validateApiOptions = Param::getArray(
            $options,
            static::OPTION_VALIDATE_API_OPTIONS,
            []
        );

        return $validateApi->__invoke(
            $value,
            $validateApiOptions
        );
    }
}
