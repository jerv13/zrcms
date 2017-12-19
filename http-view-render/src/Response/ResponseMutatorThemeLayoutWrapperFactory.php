<?php

namespace Zrcms\HttpViewRender\Response;

use Psr\Container\ContainerInterface;
use Zrcms\CoreView\Api\GetViewByRequestHtmlPage;
use Zrcms\CoreView\Api\Render\GetViewLayoutTags;
use Zrcms\CoreView\Api\Render\RenderView;
use Zrcms\Debug\IsDebug;

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
    public function __invoke($serviceContainer)
    {
        $config = $serviceContainer->get('config');

        $pageLayoutConfig = $config['zrcms-http-render-layout-for-path'];

        return new ResponseMutatorThemeLayoutWrapper(
            $serviceContainer->get(GetViewByRequestHtmlPage::class),
            $serviceContainer->get(GetViewLayoutTags::class),
            $serviceContainer->get(RenderView::class),
            $pageLayoutConfig,
            IsDebug::invoke()
        );
    }
}
