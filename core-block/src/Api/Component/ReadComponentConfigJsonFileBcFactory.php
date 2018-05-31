<?php

namespace Zrcms\CoreBlock\Api\Component;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigJsonFileBcFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadComponentConfigJsonFileBc
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ReadComponentConfigJsonFileBc(
            $serviceContainer->get(PrepareComponentConfigBlockBc::class)
        );
    }
}
