<?php

namespace Zrcms\HttpViewRender\FinalHandler;

use Psr\Container\ContainerInterface;
use Zrcms\Debug\IsDebug;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpNotFoundFinalFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpNotFoundFinal
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(ContainerInterface $serviceContainer)
    {
        return new HttpNotFoundFinal(
            HttpNotFoundFinal::DEFAULT_NOT_FOUND_STATUS,
            IsDebug::invoke()
        );
    }
}
