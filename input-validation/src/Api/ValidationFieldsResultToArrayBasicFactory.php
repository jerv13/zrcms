<?php

namespace Zrcms\InputValidation\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidationFieldsResultToArrayBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ValidationFieldsResultToArrayBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ValidationFieldsResultToArrayBasic(
            $serviceContainer->get(ValidationResultToArray::class)
        );
    }
}
