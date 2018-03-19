<?php

namespace Zrcms\HttpApiBlockRender\Validate;

use Psr\Container\ContainerInterface;
use Reliv\FieldRat\Api\FieldValidator\ValidateFieldsByFieldsModelName;
use Zrcms\Debug\IsDebug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiValidateFieldsBlockVersionFieldModelFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiValidateFieldsBlockVersionFieldModel
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiValidateFieldsBlockVersionFieldModel(
            $serviceContainer->get(ValidateFieldsByFieldsModelName::class),
            400,
            IsDebug::invoke()
        );
    }
}
