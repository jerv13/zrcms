<?php

namespace Zrcms\InputValidation\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateIsNullFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ValidateIsNull
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ValidateIsNull();
    }
}
