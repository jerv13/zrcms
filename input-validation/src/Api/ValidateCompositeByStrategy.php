<?php

namespace Zrcms\InputValidation\Api;

use Zrcms\InputValidation\Model\ValidationResult;
use Zrcms\InputValidation\Model\ValidationResultBasic;
use Zrcms\Param\Param;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateCompositeByStrategy
{
    const OPTION_VALIDATE_API_LIST = 'validate-api-list';

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
            static::OPTION_VALIDATE_API_LIST
        );

        $validateApiList = Param::getArray(
            $options,
            static::OPTION_VALIDATE_API_LIST
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
                'validate-api' => Param::getString(
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
