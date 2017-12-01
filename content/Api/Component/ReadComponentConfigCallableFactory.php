<?php

namespace Zrcms\Content\Api\Component;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class ReadComponentConfigCallableFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return ReadComponentConfigCallable
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new ReadComponentConfigCallable(
            $serviceContainer
        );
    }
}
