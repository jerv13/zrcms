<?php

namespace Zrcms\InputValidationZrcms\Api;

use Psr\Container\ContainerInterface;
use Zrcms\InputValidation\Api\ValidateFieldsHasOnlyRecognizedFields;
use Zrcms\InputValidation\Api\ValidateIsRealValue;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateCmsResourceDataUpsertFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ValidateCmsResourceDataUpsert
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ValidateCmsResourceDataUpsert(
            $serviceContainer,
            $serviceContainer->get(ValidateFieldsHasOnlyRecognizedFields::class),
            $serviceContainer->get(ValidateIsRealValue::class),
            $serviceContainer->get(ValidateContentVersionDataInsert::class),
            ValidateCmsResourceDataUpsert::DEFAULT_INVALID_CODE
        );
    }
}
