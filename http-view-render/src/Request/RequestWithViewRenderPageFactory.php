<?php

namespace Zrcms\HttpViewRender\Request;

use Psr\Container\ContainerInterface;
use Zrcms\CoreView\Api\Render\GetViewLayoutTags;
use Zrcms\CoreView\Api\Render\RenderView;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RequestWithViewRenderPageFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return RequestWithViewRenderPage
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $serviceContainer)
    {
        return new RequestWithViewRenderPage(
            $serviceContainer->get(GetViewLayoutTags::class),
            $serviceContainer->get(RenderView::class)
        );
    }
}
