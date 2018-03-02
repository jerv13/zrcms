<?php

namespace Zrcms\ValidationRatZrcms\Api\Validator;

use Psr\Container\ContainerInterface;
use Reliv\ValidationRat\Api\Validator\ValidateIsNull;
use Reliv\ValidationRat\Api\Validator\ValidateIsString;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateContentVersionIdFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ValidateContentVersionId
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ValidateContentVersionId(
            $serviceContainer->get(ValidateIsNull::class),
            $serviceContainer->get(ValidateIsString::class)
        );
    }
}
