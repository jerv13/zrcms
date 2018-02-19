<?php

namespace Zrcms\HttpViewRender\FinalHandler;

use Psr\Container\ContainerInterface;
use Zrcms\Debug\IsDebug;
use Zrcms\HttpStatusPages\Api\GetStatusPage;
use Zrcms\HttpViewRender\Response\RenderPage;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpNotFoundStatusPageFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpNotFoundStatusPage
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $serviceContainer)
    {
        return new HttpNotFoundStatusPage(
            $serviceContainer->get(GetStatusPage::class),
            $serviceContainer->get(RenderPage::class),
            HttpNotFoundFinal::DEFAULT_NOT_FOUND_STATUS,
            IsDebug::invoke()
        );
    }
}
