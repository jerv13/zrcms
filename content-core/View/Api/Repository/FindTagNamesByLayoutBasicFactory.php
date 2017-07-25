<?php

namespace Zrcms\ContentCore\View\Api\Repository;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class FindTagNamesByLayoutBasicFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return FindTagNamesByLayoutBasic
     */
    public function __invoke(
        $serviceContainer
    ) {
        return new FindTagNamesByLayoutBasic(
            $serviceContainer
        );
    }
}
