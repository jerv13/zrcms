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
     * @return ValidateContentVersionDataInsert
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ValidateContentVersionDataInsert(
            $serviceContainer,
            $serviceContainer->get(ValidateFieldsHasOnlyRecognizedFields::class),
            $serviceContainer->get(ValidateProperties::class),
            ValidateContentVersionDataInsert::DEFAULT_INVALID_CODE
        );
    }
}
