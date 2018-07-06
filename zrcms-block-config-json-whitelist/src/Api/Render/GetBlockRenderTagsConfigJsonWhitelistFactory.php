<?php

namespace Zrcms\BlockConfigJsonWhitelist\Api\Render;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\CoreBlock\Api\GetBlockData;
use Zrcms\CoreBlock\Api\GetMergedConfig;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class GetBlockRenderTagsConfigJsonWhitelistFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return GetBlockRenderTagsConfigJsonWhitelist
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $serviceContainer)
    {
        return new GetBlockRenderTagsConfigJsonWhitelist(
            $serviceContainer->get(GetBlockData::class),
            $serviceContainer->get(GetMergedConfig::class),
            $serviceContainer->get(FindComponent::class),
            $serviceContainer->get(FilterWithWhitelistInterface::class)
        );
    }
}
