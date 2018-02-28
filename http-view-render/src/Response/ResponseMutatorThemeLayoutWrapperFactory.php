<?php

namespace Zrcms\HttpViewRender\Response;

use Psr\Container\ContainerInterface;
use Zrcms\CoreView\Api\Render\GetViewLayoutTags;
use Zrcms\CoreView\Api\Render\RenderView;
use Zrcms\CoreView\Api\ViewBuilder\BuildViewHtmlPage;
use Zrcms\Debug\IsDebug;
use Zrcms\HttpViewRender\Router\LayoutThemeRouter;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ResponseMutatorThemeLayoutWrapperFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ResponseMutatorThemeLayoutWrapper
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $serviceContainer)
    {
        return new ResponseMutatorThemeLayoutWrapper(
            $serviceContainer->get(BuildViewHtmlPage::class),
            $serviceContainer->get(GetViewLayoutTags::class),
            $serviceContainer->get(RenderView::class),
            $serviceContainer->get(LayoutThemeRouter::class),
            IsDebug::invoke()
        );
    }
}
