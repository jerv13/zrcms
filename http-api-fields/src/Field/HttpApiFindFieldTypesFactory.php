<?php

namespace Zrcms\HttpApiFields\Field;

use Psr\Container\ContainerInterface;
use Reliv\FieldRat\Api\FieldType\FieldTypesToArray;
use Reliv\FieldRat\Api\FieldType\ListFieldTypes;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindFieldTypesFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiFindFieldTypes
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiFindFieldTypes(
            $serviceContainer->get(ListFieldTypes::class),
            $serviceContainer->get(FieldTypesToArray::class)
        );
    }
}
