<?php

namespace Zrcms\ViewHead\Api\Render;

use Psr\Container\ContainerInterface;

/**
 * @author James Jervis - https://github.com/jerv13
 */
class RenderHeadSectionTagCompositeFactory
{
    /**
     * @param ContainerInterface $serviceContainer
     *
     * @return RenderHeadSectionTagComposite
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function __invoke(
        $serviceContainer
    ) {
        $appConfig = $serviceContainer->get('config');

        return new RenderHeadSectionTagComposite(
            $serviceContainer,
            $appConfig['zrcms-view-head.section-tag-render-api']
        );
    }
}
