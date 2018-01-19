<?php

namespace Zrcms\InputValidationMessages\Api;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetMessagesValidationResultFieldsBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetMessagesValidationResultFieldsBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new GetMessagesValidationResultFieldsBasic(
            $serviceContainer->get(GetMessagesValidationResult::class)
        );
    }
}
