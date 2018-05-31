<?php

namespace Zrcms\CoreBlock\Api\Component;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigJsonFileFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadComponentConfigJsonFile
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ReadComponentConfigJsonFile(
            $serviceContainer->get(PrepareComponentConfigBlockFieldsToDefaultConfig::class)
        );
    }
}
