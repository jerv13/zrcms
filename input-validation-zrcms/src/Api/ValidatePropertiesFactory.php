<?php

namespace Zrcms\InputValidationZrcms\Api;

use Psr\Container\ContainerInterface;
use Zrcms\InputValidation\Api\ValidateFieldsHasOnlyRecognizedFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidatePropertiesFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ValidateProperties
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ValidateProperties(
            $serviceContainer,
            $serviceContainer->get(ValidateFieldsHasOnlyRecognizedFields::class),
            ValidateProperties::DEFAULT_INVALID_CODE
        );
    }
}
