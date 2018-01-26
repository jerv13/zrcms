<?php

namespace Zrcms\Fields\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Fields\Api\FieldType\FindFieldType;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ValidateByFieldTypeRequiredFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ValidateByFieldTypeRequired
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ValidateByFieldTypeRequired(
            $serviceContainer,
            $serviceContainer->get(FindFieldType::class)
        );
    }
}
