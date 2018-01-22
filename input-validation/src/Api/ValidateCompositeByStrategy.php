<?php

namespace Zrcms\InputValidation\Api;

use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\InputValidation\Model\ValidationResultBasic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateCompositeByStrategy implements Validate
{
    const OPTION_VALIDATORS = 'validators';

    protected $validateByStrategy;

    /**
     * @param ValidateByStrategy $validateByStrategy
     */
    public function __construct(
        ValidateByStrategy $validateByStrategy
    ) {
        $this->validateByStrategy = $validateByStrategy;
    }

    /**
     * @param       $value
     * @param array $options
     *
     * @return ValidationResult
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     * @throws \Throwable
     * @throws \Zrcms\InputValidation\Exception\ValidateApiInvalid
     * @throws \Zrcms\Param\Exception\ParamException
     */
    public function __invoke(
        $value,
        array $options = []
    ): ValidationResult {
        $valid = true;
        $code = '';
        $validationResults = [];

        Param::assertNotEmpty(
            $options,
            static::OPTION_VALIDATORS
        );

        $validateApiList = Param::getArray(
            $options,
            static::OPTION_VALIDATORS
        );

        /** @var string $validateApiServiceName */
        foreach ($validateApiList as $validationConfig) {
            $validationResult = $this->validateByStrategy->__invoke(
                $value,
                $validationConfig
            );

            // Use the first code we get
            if (!$validationResult->isValid() && $valid) {
                $valid = false;

                $code = $validationResult->getCode();
            }

            $validationResults[] = [
                'validator' => Param::getString(
                    $options,
                    ValidateByStrategy::OPTION_VALIDATE_API
                ),
                'valid' => $validationResult->isValid(),
                'code' => $validationResult->getCode(),
                'details' => $validationResult->getDetails(),
            ];
        };

        return new ValidationResultBasic(
            $valid,
            $code,
            [
                'validation-results' => $validationResults
            ]
        );
    }
}
