<?php

namespace Zrcms\HttpStatusPages\Middleware;

use Psr\Container\ContainerInterface;
use Zrcms\Debug\IsDebug;
use Zrcms\HttpStatusPages\Api\GetStatusPage;
use Zrcms\HttpViewRender\Request\RequestWithViewStrategyPageVersionId;
use Zrcms\HttpViewRender\Response\RenderPage;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ResponseMutatorStatusPageFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ResponseMutatorStatusPage
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new ResponseMutatorStatusPage(
            $serviceContainer->get(GetStatusPage::class),
            $serviceContainer->get(RenderPage::class),
            ['text/html', 'application/xhtml+xml', 'text/xml', 'application/xml', ''],
            [200, 201, 204, 301, 302],
            // @todo This should be defined at the application layer or in config
            [RequestWithViewStrategyPageVersionId::PARAM_VIEW_PAGE_VERSION_ID],
            ResponseMutatorStatusPage::DEFAULT_QUERY_PARAM_BLACKLIST_PREFIX,
            IsDebug::invoke()
        );
    }
}
