<?php

namespace Zrcms\CoreView\Api\ViewBuilder;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class DetermineViewStrategyHtmlPageFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return DetermineViewStrategyHtmlPage
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new DetermineViewStrategyHtmlPage();
    }
}
