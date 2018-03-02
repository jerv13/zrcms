<?php

namespace Zrcms\ValidationRatZrcms\Api\FieldValidator;

use Psr\Container\ContainerInterface;
use Reliv\ValidationRat\Api\FieldValidator\ValidateFieldsHasOnlyRecognizedFields;
use Reliv\ValidationRat\Api\Validator\ValidateIsRealValue;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateFieldsUpsertCmsResourceDataFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ValidateFieldsUpsertCmsResourceData
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ValidateFieldsUpsertCmsResourceData(
            $serviceContainer->get(BuildFieldValidationResults::class),
            $serviceContainer->get(ValidateFieldsHasOnlyRecognizedFields::class),
            $serviceContainer->get(ValidateIsRealValue::class),
            ValidateFieldsUpsertCmsResourceData::DEFAULT_INVALID_CODE
        );
    }
}
