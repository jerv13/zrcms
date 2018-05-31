<?php

namespace Zrcms\CoreBlock\Api\Component;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class PrepareComponentConfigBlockFieldsToDefaultConfigFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return PrepareComponentConfigBlockFieldsToDefaultConfig
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new PrepareComponentConfigBlockFieldsToDefaultConfig();
    }
}
