<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderHeadSectionTagByServiceFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return RenderHeadSectionTagByService
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        $serviceContainer
    ) {
        $appConfig = $serviceContainer->get('config');

        return new RenderHeadSectionTagByService(
            $serviceContainer
        );
    }
}
