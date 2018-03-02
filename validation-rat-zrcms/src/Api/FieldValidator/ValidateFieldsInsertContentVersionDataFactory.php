<?php

namespace Zrcms\ValidationRatZrcms\Api\FieldValidator;

use Psr\Container\ContainerInterface;
use Reliv\FieldRat\Api\FieldValidator\ValidateFieldsByFieldsModelName;
use Reliv\ValidationRat\Api\FieldValidator\ValidateFieldsHasOnlyRecognizedFields;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateFieldsInsertContentVersionDataFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ValidateFieldsInsertContentVersionData
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ValidateFieldsInsertContentVersionData(
            $serviceContainer->get(BuildFieldValidationResults::class),
            $serviceContainer->get(ValidateFieldsHasOnlyRecognizedFields::class),
            ValidateFieldsInsertContentVersionData::DEFAULT_INVALID_CODE
        );
    }
}
