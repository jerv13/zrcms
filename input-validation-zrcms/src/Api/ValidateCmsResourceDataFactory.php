<?php

namespace Zrcms\InputValidationZrcms\Api;

use Psr\Container\ContainerInterface;
use Zrcms\InputValidation\Api\ValidateFieldsHasOnlyRecognizedFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateCmsResourceDataFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ValidateCmsResourceData
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ValidateCmsResourceData(
            $serviceContainer,
            $serviceContainer->get(ValidateFieldsHasOnlyRecognizedFields::class),
            $serviceContainer->get(ValidateContentVersionData::class),
            ValidateCmsResourceData::DEFAULT_INVALID_CODE
        );
    }
}
