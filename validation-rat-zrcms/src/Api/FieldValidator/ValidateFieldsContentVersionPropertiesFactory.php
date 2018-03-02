<?php

namespace Zrcms\ValidationRatZrcms\Api\FieldValidator;

use Psr\Container\ContainerInterface;
use Reliv\FieldRat\Api\FieldValidator\ValidateFieldsByFieldsModelName;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateFieldsContentVersionPropertiesFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ValidateFieldsContentVersionProperties
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ValidateFieldsContentVersionProperties(
            $serviceContainer->get(ValidateFieldsByFieldsModelName::class)
        );
    }
}
