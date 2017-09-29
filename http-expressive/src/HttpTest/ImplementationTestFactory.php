<?php

namespace Zrcms\HttpExpressive\HttpTest;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ImplementationTestFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ImplementationTest
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new ImplementationTest(
            $serviceContainer
        );
    }
}
