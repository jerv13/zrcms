<?php

namespace Zrcms\ValidationRatZrcms\Api\Validator;

use Psr\Container\ContainerInterface;
use Reliv\ValidationRat\Api\Validator\ValidateIsString;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateContentVersionExistsFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ValidateContentVersionExists
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ValidateContentVersionExists(
            $serviceContainer,
            $serviceContainer->get(ValidateIsString::class)
        );
    }
}
