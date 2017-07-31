<?php

namespace Zrcms\HttpExpressive1\Render;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ViewControllerTestFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ViewControllerTest
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new ViewControllerTest(
            $serviceContainer
        );
    }
}
