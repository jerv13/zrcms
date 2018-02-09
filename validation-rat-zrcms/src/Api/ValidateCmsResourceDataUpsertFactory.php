<?php

namespace Zrcms\ValidationRatZrcms\Api;

use Psr\Container\ContainerInterface;
use Reliv\ValidationRat\Api\FieldValidator\ValidateFieldsHasOnlyRecognizedFields;
use Reliv\ValidationRat\Api\Validator\ValidateIsRealValue;

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
