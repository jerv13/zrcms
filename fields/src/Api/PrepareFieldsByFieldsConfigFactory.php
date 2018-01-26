<?php

namespace Zrcms\Fields\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PrepareFieldsByFieldsConfigFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return PrepareFieldsByFieldsConfig
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new PrepareFieldsByFieldsConfig(
            $serviceContainer->get(ValidateByFieldTypeRequired::class)
        );
    }
}
