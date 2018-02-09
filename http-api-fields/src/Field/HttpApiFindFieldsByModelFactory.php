<?php

namespace Zrcms\HttpApiFields\Field;

use Psr\Container\ContainerInterface;
use Reliv\FieldRat\Api\Field\FieldsToArray;
use Reliv\FieldRat\Api\Field\FindFieldsByModel;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiFindFieldsByModelFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiFindFieldsByModel
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiFindFieldsByModel(
            $serviceContainer->get(FindFieldsByModel::class),
            $serviceContainer->get(FieldsToArray::class),
            404
        );
    }
}
