<?php

namespace Zrcms\HttpTest\Middleware;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpViewTestFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpViewTest
     */
    public function __invoke(
        ContainerInterface $serviceContainer
    ) {
        return new HttpViewTest(
            $serviceContainer
        );
    }
}
