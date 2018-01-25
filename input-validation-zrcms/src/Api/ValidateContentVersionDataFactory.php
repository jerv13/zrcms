<?php

namespace Zrcms\InputValidationZrcms\Api;

use Psr\Container\ContainerInterface;
use Zrcms\InputValidation\Api\ValidateFieldsHasOnlyRecognizedFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateContentVersionDataFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ValidateContentVersionData
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ValidateContentVersionData(
            $serviceContainer,
            $serviceContainer->get(ValidateFieldsHasOnlyRecognizedFields::class),
            $serviceContainer->get(ValidateProperties::class),
            ValidateContentVersionData::DEFAULT_INVALID_CODE
        );
    }
}
