<?php

namespace Zrcms\ValidationRatZrcms\Api\FieldValidator;

use Psr\Container\ContainerInterface;
use Reliv\ArrayProperties\Property;
use Reliv\ValidationRat\Api\Validator\Validate;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class BuildFieldValidationResultsServices implements BuildFieldValidationResults
{
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
     * @param array  $data
     * @param array  $fieldResults
     * @param string $fieldKey
     * @param string $validatorKey
     * @param string $optionsKey
     * @param string $defaultValidator
     * @param array  $defaultValidatorOptions
     * @param array  $options
     *
     * @return array
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        array $data,
        array $fieldResults,
        string $fieldKey,
        string $validatorKey,
        string $optionsKey,
        string $defaultValidator,
        array $defaultValidatorOptions,
        array $options = []
    ):array {
        $validatorServiceName = Property::getString(
            $options,
            $validatorKey,
            $defaultValidator
        );

        /** @var Validate $validator */
        $validator = $this->serviceContainer->get($validatorServiceName);

        $fieldResults[$fieldKey] = $validator->__invoke(
            Property::get(
                $data,
                $fieldKey
            ),
            Property::getArray(
                $options,
                $optionsKey,
                $defaultValidatorOptions
            )
        );

        return $fieldResults;
    }
}
