<?php

namespace Zrcms\HttpViewRender\Response;

use Psr\Container\ContainerInterface;
use Zrcms\CoreView\Api\GetViewByRequest;
use Zrcms\CoreView\Api\Render\GetViewLayoutTags;
use Zrcms\CoreView\Api\Render\RenderView;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderPageFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return RenderPage
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $serviceContainer)
    {
        return new RenderPage(
            $serviceContainer->get(GetViewByRequest::class),
            $serviceContainer->get(GetViewLayoutTags::class),
            $serviceContainer->get(RenderView::class)
        );
    }
}
