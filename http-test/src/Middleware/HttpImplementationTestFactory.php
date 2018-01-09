<?php

namespace Zrcms\HttpTest\Middleware;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class HttpImplementationTestFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return HttpImplementationTest
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new HttpImplementationTest(
            $serviceContainer
        );
    }
}
