<?php

namespace Zrcms\CoreBlock\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\CoreBlock\Api\GetBlockData;
use Zrcms\CoreBlock\Api\GetMergedConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlockRenderTagsBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetBlockRenderTagsBasic
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $serviceContainer)
    {
        return new GetBlockRenderTagsBasic(
            $serviceContainer->get(GetBlockData::class),
            $serviceContainer->get(GetMergedConfig::class)
        );
    }
}
