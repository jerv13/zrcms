<?php

namespace Zrcms\Fields\Api;

use Psr\Container\ContainerInterface;
use Zrcms\Fields\Api\Field\FindFieldsByModel;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PrepareFieldsByFieldsModelNameFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return PrepareFieldsByFieldsModelName
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new PrepareFieldsByFieldsModelName(
            $serviceContainer->get(ValidateByFieldTypeRequired::class),
            $serviceContainer->get(FindFieldsByModel::class)
        );
    }
}
