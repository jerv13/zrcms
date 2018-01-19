<?php

namespace Zrcms\InputValidation\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidationResultFieldsToArrayBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ValidationResultFieldsToArrayBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ValidationResultFieldsToArrayBasic(
            $serviceContainer->get(ValidationResultToArray::class)
        );
    }
}
