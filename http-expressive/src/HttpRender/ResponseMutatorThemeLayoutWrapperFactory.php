<?php

namespace Zrcms\HttpExpressive\HttpRender;

use Psr\Container\ContainerInterface;
use Zrcms\ContentCore\View\Api\GetViewByRequestHtmlPage;
use Zrcms\ContentCore\View\Api\Render\GetViewLayoutTags;
use Zrcms\ContentCore\View\Api\Render\RenderView;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ResponseMutatorThemeLayoutWrapperFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ResponseMutatorThemeLayoutWrapper
     */
    public function __invoke($serviceContainer)
    {
        $config = $serviceContainer->get('config');

        $pageLayoutConfig = $config['zrcms-http-render-layout-for-path'];

        return new ResponseMutatorThemeLayoutWrapper(
            $serviceContainer->get(GetViewByRequestHtmlPage::class),
            $serviceContainer->get(GetViewLayoutTags::class),
            $serviceContainer->get(RenderView::class),
            $pageLayoutConfig
        );
    }
}
