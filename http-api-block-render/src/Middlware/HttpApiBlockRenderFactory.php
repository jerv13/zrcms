<?php

namespace Zrcms\HttpApiBlockRender\Middleware;

use Psr\Container\ContainerInterface;
use Zrcms\Core\Api\Component\FindComponent;
use Zrcms\Core\Api\Content\ContentVersionToArray;
use Zrcms\CoreBlock\Api\Render\GetBlockRenderTags;
use Zrcms\CoreBlock\Api\Render\RenderBlock;
use Zrcms\Debug\IsDebug;
use Zrcms\User\Api\GetUserIdByRequest;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpApiBlockRenderFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpApiBlockRender
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpApiBlockRender(
            $serviceContainer->get(FindComponent::class),
            $serviceContainer->get(GetBlockRenderTags::class),
            $serviceContainer->get(RenderBlock::class),
            $serviceContainer->get(GetUserIdByRequest::class),
            $serviceContainer->get(ContentVersionToArray::class),
            404,
            IsDebug::invoke()
        );
    }
}
